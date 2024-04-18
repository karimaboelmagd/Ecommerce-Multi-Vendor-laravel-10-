<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class IndexController extends Controller
{

    public function home()
    {
        $banners=Banner::where(['status'=>'active','condition'=>'banner'])->orderBy('id','DESC')->limit('5')->get();
        $categories=Category::where(['status'=>'active','is_parent'=>1])->orderBy('id','DESC')->limit('3')->get();
        return view('frontend.index',compact(['banners','categories']));
    }

    public function productCategory(Request $request,$slug)
    {
        $categories=Category::with('products')->where('slug',$slug)->first();

        $sort='';
        if($request->sort !=null){
            $sort=$request->sort ;
        }

        if ($categories==null){
            return view ('errors.404');
        }
        else{
            if($sort=='priceASC'){

                $products=Product::where(['status'=>'active','cat_id'=>$categories->id])->orderBy('offer_price','ASC')->paginate('12');
            }
            elseif ($sort=='priceDesc'){
                $products=Product::where(['status'=>'active','cat_id'=>$categories->id])->orderBy('offer_price','DESC')->paginate('12');

            }
            elseif ($sort=='discASC'){
                $products=Product::where(['status'=>'active','cat_id'=>$categories->id])->orderBy('price','ASC')->paginate('12');

            }
            elseif ($sort=='discDesc'){
                $products=Product::where(['status'=>'active','cat_id'=>$categories->id])->orderBy('price','ASC')->paginate('12');

            }
            elseif ($sort=='titleASC'){
                $products=Product::where(['status'=>'active','cat_id'=>$categories->id])->orderBy('price','ASC')->paginate('12');

            }
            elseif ($sort=='titleDesc'){
                $products=Product::where(['status'=>'active','cat_id'=>$categories->id])->orderBy('price','DESC')->paginate('12');

            }
            else{
                $products=Product::where(['status'=>'active','cat_id'=>$categories->id])->paginate('12');

            }
        }


        $route='product-category';

        //For Loading More Data By Ajax
        if($request->ajax()){
            $view=View('frontend.layouts.single-product',compact('products'))->render();
            return response()->json(['html'=>$view]);
        }
        return view('frontend.pages.product.product-category',compact(['categories','route','products']));
    }

    public function productDetails($slug){

        $product=Product::with('related_products')->where('slug',$slug)->first();
        if($product){
            return view('frontend.pages.product.product-details',compact('product'));

        }
        else{
            return 'Product Details Not Found';
        }

    }

    public function userAuth(){

        return view('frontend.auth.auth');
    }


    public function loginSubmit(Request $request)
    {
        $this->validate($request, [

            'email' => 'email|required|exists:users,email',
            'password' => 'required|min:4',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status'=>'active'])) {
            Session::put('user', $request->email);

            if (Session::get('url.intended')) {
                return Redirect::to(Session::get('url.intended'));
            } else {
                return redirect()->route('home.page')->with('success','Successfully Login');

            }
        } else {
            return back()->with('error', 'Invalid Email Or Password!');

        }

    }

    public function registerSubmit(Request $request){

        $this->validate($request, [

            'full_name'=>'nullable|string',
            'username'=>'required|string',
            'email' => 'email|required|unique:users,email',
            'password' => 'required|min:4|confirmed',
        ]);
        $data=$request->all();
        $check=$this->creat($data);
        Session::put('user',$data['email']);
        Auth::login($check);
        if($check){
            return redirect()->route('home.page')->with('success','Successfully Registered');
        }
        else{
            return back()->with('error',['Please Check Your Credentials']);
        }
    }

    private function creat(array $data){
        return User::create([
            'full_name'=>$data['full_name'],
            'username'=>$data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            ]);
    }

    public function userLogout(){
    Session::forget('user');
    Auth::logout();
    return redirect()->route('home.page')->with('success','Successfully Logout');
    }

    public function userDashboard(){

        $user=Auth::user();
        return view('frontend.user.dashboard',compact('user'));

    }

    public function userOrder(){

        $user=Auth::user();
        return view('frontend.user.order',compact('user'));

    }
    public function userAddress(){

        $user=Auth::user();
        return view('frontend.user.address',compact('user'));

    }

    public function userAccountdetails(){

        $user=Auth::user();
        return view('frontend.user.account-details',compact('user'));

    }


}
