<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners=Banner::orderBy('id','DESC')->get();
       return view('backend.banners.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.banners.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'photo'=>'required',
            'condition'=>'nullable|in:banner,promo',
            'status'=>'nullable|in:active,inactive',
        ]);

        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Banner::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $status = Banner::create($data);
        if($status){

            return redirect()->route('banner.index')->with('success', 'Banner Has Been Created Successfully');
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
        $banner=Banner::findOrFail($id);
        if ($banner){
            return view('backend.banners.edit',compact('banner'));
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
        $banner=Banner::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'photo'=>'string|required',
            'status'=>'required|in:active,inactive',
        ]);
        $data=$request->all();

        $status=$banner->fill($data)->save();
        if($status){
            request()->session()->flash('success','Banner Has Been Updated Successfully ');
        }
        else{
            request()->session()->flash('error','Error Occurred While Updating Banner');
        }
        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner=Banner::findOrFail($id);
        $status=$banner->delete();
        if($status){
            request()->session()->flash('success','Banner Has Been deleted Successfully ');
        }
        else{
            request()->session()->flash('error','Error Occurred While Deleting Banner');
        }
        return redirect()->route('banner.index');
    }



//    public function bannerStatus(Request $request)
//    {
//        if($request->mode=='true'){
//            DB::table('banners')->where('id',$request->id)->update(['status'=>'active']);
//        }
//        else{
//            DB::table('banners')->where('id',$request->id)->update(['status'=>'inactive']);
//
//        }
//        return response()->json([
//            'msg'=>'Status Has Been Updated Successfully ','status'=>true
//        ]);
//    }
}
