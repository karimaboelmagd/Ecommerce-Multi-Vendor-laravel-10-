<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
////FrontEnd Section////

##Authentication
Route::get('user/auth',[IndexController::class,'userAuth'])->name('user.auth');
Route::post('user/login',[IndexController::class,'loginSubmit'])->name('login.submit');
Route::post('user/register',[IndexController::class,'registerSubmit'])->name('register.submit');
Route::get('user/logout',[IndexController::class,'userLogout'])->name('user.logout');




Route::get('/',[IndexController::class,'home'] )->name('home.page');


##Product Category Section
Route::get('/product-category/{slug}/',[IndexController::class,'productCategory'])->name('product.category');

##Product Details Section
Route::get('/product-details/{slug}/',[IndexController::class,'productDetails'])->name('product.details');



###################################################################################################################

////BackEnd Section////


Auth::routes(['register'=>false]);
Route::get('/home', [HomeController::class, 'index'])->name('home');


                           ////Admin Sections////

Route::group(['prefix'=>'admin','middleware'=>'auth','admin'],function(){
    Route::get('/', [AdminController::class, 'admin'])->name('admin');

##Banner Section

    Route::resource('banner', BannerController::class);
//    Route::post('banner_status', [BannerController::class, 'bannerStatus'])->name('banner.status');

##Category Section

    Route::resource('category', CategoryController::class);
//    Route::post('category_status', [CategoryController::class, 'categoryStatus'])->name('category.status');
    Route::post('category/{id}/child',[CategoryController::class, 'getChildByParentID']);


##Brand Section

    Route::resource('brand', BrandController::class);
//    Route::post('brand_status', [BrandController::class, 'brandStatus'])->name('brand.status');

##Product Section

    Route::resource('product', ProductController::class);
//    Route::post('product_status', [ProductController::class, 'productStatus'])->name('product.status');


##User Section

    Route::resource('user', UserController::class);
//    Route::post('user_status', [UserController::class, 'userStatus'])->name('user.status');

});


                        ////Seller Sections////

Route::group(['prefix'=>'seller','middleware'=>'auth','seller'],function(){
    Route::get('/', [AdminController::class, 'seller'])->name('seller');
});


                        ////User Sections////

Route::group(['prefix'=>'user'],function (){
    Route::get('/dashboard',[IndexController::class,'userDashboard'])->name('user.dashboard');
    Route::get('/orders',[IndexController::class,'userOrder'])->name('user.orders');
    Route::get('/address',[IndexController::class,'userAddress'])->name('user.address');
    Route::get('/account-details',[IndexController::class,'userAccountdetails'])->name('user.details');
});
