<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductSubCategoryController;


use App\Http\Controllers\front\FrontController;
use App\Http\Controllers\front\ShopController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Front page controller 

Route::get('/',[FrontController::class,'index'])->name('front.home');
Route::get('/shop/{categorySlug?}/{subcategorySlug?}',[ShopController::class,'index'])->name('front.shop');
Route::get('/product/{productSlug}',[ShopController::class,'product'])->name('front.product');
Route::get('products/get-products', [ProductController::class, 'getProducts'])->name('product.related-product');

// Admin page Controllers

Route::group(['prefix' => 'admin'],function(){

    Route::group(['middleware' => 'admin.guest'],function(){

        Route::get('/index',[AdminLoginController::class,'index'])->name('admin.login');

        Route::post('/authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');

    });

    // Route::get('products/get-products', [ProductController::class, 'getProducts'])->name('product.related-product');
    Route::group(['middleware' => 'admin.auth'],function(){
        //dashboard controller route
        Route::get('/dashboard',[HomeController::class,'index'])->name('admin.dashboard');

        Route::get('/logout',[HomeController::class,'logout'])->name('admin.logout');

        //category controller route
        Route::resource('/category',CategoryController::class);

        //sub-category controller route
        Route::resource('/subcategory',SubCategoryController::class);

        //brands controller route
        Route::resource('/brands',BrandController::class);

        //products controller route
        Route::resource('/products',ProductController::class);


        //product subcategory controller route
        Route::get('products-subcategory',[ProductSubCategoryController::class,'getSubCat'])->name('product_subcategory');
    });
});
