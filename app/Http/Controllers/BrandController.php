<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands=Brand::orderBy('id','DESC')->get();
        return view('backend.brands.index',compact('brands'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'photo'=>'required',
            'status'=>'nullable|in:active,inactive',
        ]);

        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Brand::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $status = Brand::create($data);
        if($status){

            return redirect()->route('brand.index')->with('success', 'Brand Has Been Created Successfully');
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
        $brand=Brand::findOrFail($id);
        if ($brand){
            return view('backend.brands.edit',compact('brand'));
        }
        else{
            return back()->with('error','Data Not Found');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand=Brand::findOrFail($id);
        $status=$brand->delete();
        if($status){
            request()->session()->flash('success','Brand Has Been Deleted Successfully ');
        }
        else{
            request()->session()->flash('error','Error Occurred While Deleting Brand');
        }
        return redirect()->route('brand.index');    }

//public function brandStatus(Request $request)
//    {
//        if($request->mode=='true'){
//            DB::table('brands')->where('id',$request->id)->update(['status'=>'active']);
//        }
//        else{
//            DB::table('brands')->where('id',$request->id)->update(['status'=>'inactive']);
//
//        }
//        return response()->json([
//            'msg'=>'Status Has Been Updated Successfully ','status'=>true
//        ]);
//    }
}
