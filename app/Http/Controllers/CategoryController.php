<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Category::orderBy('id','DESC')->get();
        return view('backend.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parent_cats=Category::where('is_parent',1)->orderBy('title','ASC')->get();
        return view('backend.categories.create',compact('parent_cats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|nullable',
            'photo'=>'string|nullable',
            'status'=>'required|in:active,inactive',
            'is_parent'=>'sometimes|in:1',
            'parent_id'=>'nullable|exists:categories,id',
        ]);
        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Category::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $data['is_parent']=$request->input('is_parent',0);
        $status = Category::create($data);
        if($status){

            return redirect()->route('category.index')->with('success', 'Category Has Been Created Successfully');
        }
        else{
            return back()->with('error', 'Something Went Wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category=Category::findOrFail($id);
        $parent_cats=Category::where('is_parent',1)->orderBy('title','ASC')->get();
        return view('backend.categories.edit',compact(['category','parent_cats']));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category=Category::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|nullable',
            'photo'=>'string|nullable',
            'status'=>'required|in:active,inactive',
            'is_parent'=>'sometimes|in:1',
            'parent_id'=>'nullable|exists:categories,id',
        ]);
        $data= $request->all();
        $data['is_parent']=$request->input('is_parent',0);
        // return $data;
        $status=$category->fill($data)->save();
        if($status){
            request()->session()->flash('success','Category Has Been Updated Successfully ');
        }
        else{
            request()->session()->flash('error','Error Occurred While Updating Category!');
        }
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category=Category::findOrFail($id);
        $child_cat_id=Category::where('parent_id',$id)->pluck('id');
        $status=$category->delete();
        if($status){
            if(count($child_cat_id)>0){
                Category::shiftChild($child_cat_id);
            }
            request()->session()->flash('success','Category Has Been Deleted Successfully ');
        }
        else{
            request()->session()->flash('error','Error Occurred While Deleting Category');
        }
        return redirect()->route('category.index');
    }


    //    public function categoryStatus(Request $request)
//    {
//        if($request->mode=='true'){
//            DB::table('categories')->where('id',$request->id)->update(['status'=>'active']);
//        }
//        else{
//            DB::table('categories')->where('id',$request->id)->update(['status'=>'inactive']);
//
//        }
//        return response()->json([
//            'msg'=>'Status Has Been Updated Successfully ','status'=>true
//        ]);
//    }
    public function getChildByParentID(Request $request,$id)
     {
         $category=Category::findOrFail($request->id);
         if($category){
             $child_cat=Category::getChildByParentID($request->id);

         if(count($child_cat)<=0){
             return response()->json(['status'=>false,'msg'=>'','data'=>null]);

         }
             return response()->json(['status'=>true,'msg'=>'','data'=>$child_cat]);
         }
         else{
             return response()->json(['status'=>false,'msg'=>'','data'=>null]);
         }
     }

}
