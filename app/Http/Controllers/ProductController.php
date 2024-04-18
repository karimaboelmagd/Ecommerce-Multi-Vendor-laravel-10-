<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Product::orderBy('id','DESC')->get();
        return view('backend.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            'stock'=>'required|numeric',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric',
            'photo'=>'required',
            'cat_id'=>'required|exists:categories,id',
            'child_cat_id'=>'nullable|exists:categories,id',
            'size'=>'nullable',
            'condition'=>'nullable',
            'status'=>'required|in:active,inactive',
            'brand_id'=>'nullable|exists:brands,id',
        ]);
        $data=$request->all();

        $slug=Str::slug($request->input('title'));
        $slug_count=Product::where('slug',$slug)->count();
        if($slug_count>0){
            $slug = time().'-'.$slug;
        }
        $data['slug']=$slug;
        $data['offer_price']=($request->price-(($request->price*$request->discount)/100));
//        return $data;
        $status=Product::create($data);
        if($status){
            return redirect()->route('product.index')->with('success','Product Has Been Created Successfully');
        }
        else{
            request()->session()->flash('error','Please try again!!');
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
        $product=Product::findOrFail($id);
        if ($product){
            return view('backend.products.edit',compact('product'));
        }
        else{
            return back()->with('error','Product Not Found');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product=Product::findOrFail($id);
        if($product) {
            $this->validate($request, [
                'title' => 'string|required',
                'summary' => 'string|required',
                'description' => 'string|nullable',
                'stock' => 'required|numeric',
                'price' => 'required|numeric',
                'discount' => 'nullable|numeric',
                'photo' => 'required',
                'cat_id' => 'required|exists:categories,id',
                'child_cat_id' => 'nullable|exists:categories,id',
                'size' => 'nullable',
                'condition' => 'nullable',
                'status' => 'required|in:active,inactive',
                'brand_id' => 'nullable|exists:brands,id',
            ]);
            $data = $request->all();
            $data['offer_price'] = ($request->price - (($request->price * $request->discount) / 100));
            $status = $product->fill($data)->save();
            if ($status) {
                return redirect()->route('product.index')->with('success', 'Product Has Been Updated Successfully');
            } else {
                return back()->with('error', 'Error Occurred While Updating Product!');
            }
        }
        return back()->with('error', 'Product Not Found!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if ($product) {
            $status = $product->delete();
            if ($status) {
                return redirect()->route('product.index')->with('success', 'Product Has Been Deleted Successfully');
            } else {
                return back()->with('error', 'Something Went Wrong!');
            }
        }

        else{
            return back()->with('error','Data Not Found');
        }
    }



    //    public function productStatus(Request $request)
//    {
//        if($request->mode=='true'){
//            DB::table('products')->where('id',$request->id)->update(['status'=>'active']);
//        }
//        else{
//            DB::table('products')->where('id',$request->id)->update(['status'=>'inactive']);
//
//        }
//        return response()->json([
//            'msg'=>'products Has Been Updated Successfully ','status'=>true
//        ]);
//    }

}
