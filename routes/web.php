<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\DiscountCouponController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductRatingController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\ShippingChargeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
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
// Route::get('/send', function () {
//     orderEmail(5);
// });

// Front page controller 

Route::get('/',[FrontController::class,'index'])->name('front.home');
Route::get('/shop/{categorySlug?}/{subcategorySlug?}',[ShopController::class,'index'])->name('front.shop');
Route::get('/product/{productSlug}',[ShopController::class,'product'])->name('front.product');

// cart related route
Route::get('/cart',[CartController::class,'cart'])->name('front.cart');
Route::post('/add-to-cart',[CartController::class, 'addToCart'])->name('front.addToCart');
Route::post('/cart-update',[CartController::class, 'updateCart'])->name('cart.updateCart');
Route::post('/cart-delete-item',[CartController::class, 'deleteCartItem'])->name('front.cartDeleteItem');

// checkout related route
Route::get('/checkout',[CartController::class,'checkout'])->name('front.checkout');
Route::post('/checkout-process',[CartController::class,'checkoutProcess'])->name('front.checkoutProcess');
Route::get('/thanks/{id}',[CartController::class,'thanks'])->name('front.thanks');
Route::post('/get-order-summery',[CartController::class,'getOrderSummery'])->name('front.getOrderSummery');

// discount coupone code route
Route::post("/apply-discount",[CartController::class,'applyDiscount'])->name('front.applyDiscount');
Route::post("/delete-discount",[CartController::class,'deleteDiscount'])->name('front.deleteDiscount');

// wishlist related route
Route::post('add-to-wishlist',[FrontController::class,'addToWishlist'])->name('front.addToWishlist');

// $page related route
Route::get('page/{slug?}',[FrontController::class,'page'])->name('front.page');
Route::post('send-contact-email',[FrontController::class,'sendContactEmail'])->name('front.sendContactEmail');

// forgot password related route
Route::get('forgot-password',[AuthController::class,'forgotPassword'])->name('front.forgotPassword');
Route::post('process-forgot-password',[AuthController::class,'processFrogotPassword'])->name('front.processFrogotPassword');
Route::get('reset-password/{token}',[AuthController::class,'resetPassword'])->name('front.resetPassword');
Route::post('process-reset-password',[AuthController::class,'processResetPassword'])->name('front.processResetPassword');

// rating realted route
Route::post('save-rating/{productId}',[ShopController::class,'saveRating'])->name('font.saveRating');


// account register route
Route::group(['prefix' => 'account'],function(){
    Route::group(['middleware' => 'guest'],function(){
        Route::get('/login',[AuthController::class,'login'])->name('account.login');
        Route::post('/authenticate',[AuthController::class,'authenticate'])->name('account.authenticate');
        Route::get('/register',[AuthController::class,'register'])->name('account.register');
        Route::post('/register-process',[AuthController::class,'registerProcess'])->name('account.registerProcess');
    });

    Route::group(['middleware' => 'auth'],function(){
        Route::get('logout',[AuthController::class,'logout'])->name('account.logout');
        Route::get('profile',[AuthController::class,'profile'])->name('account.profile');
        Route::post('profile-update',[AuthController::class,'updateProfile'])->name('account.updateProfile');
        Route::post('update-address',[AuthController::class,'updateAddress'])->name('account.updateAddress');
        Route::get('my-orders',[AuthController::class,'orders'])->name('account.orders');
        Route::get('orders-details/{id}',[AuthController::class,'orderDetails'])->name('account.orderDetails');
        Route::get('my-wishlist',[AuthController::class,'wishlist'])->name('account.wishlist');
        Route::post('delete-from-wishlist-product',[AuthController::class,'deleteWishlistPorduct'])->name('account.deleteWishlistPorduct');
        Route::get('change-password',[AuthController::class,'showChangePasswordFrom'])->name('account.changePassword');
        Route::post('process-change-password',[AuthController::class,'changePassword'])->name('account.processChangePassword');
    });
});

// Admin page Controllers

Route::group(['prefix' => 'admin'],function(){

    Route::group(['middleware' => 'admin.guest'],function(){

        Route::get('/index',[AdminLoginController::class,'index'])->name('admin.login');

        Route::post('/authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');

    });

    // Route::get('products/get-products', [ProductController::class, 'getProducts'])->name('product.related-product');
    Route::group(['middleware' => 'admin.auth'],function(){
        //dashboard controller route
        Route::get('dashboard',[HomeController::class,'index'])->name('admin.dashboard');

        Route::get('logout',[HomeController::class,'logout'])->name('admin.logout');

        //category controller route
        Route::resource('category',CategoryController::class);

        //sub-category controller route
        Route::resource('subcategory',SubCategoryController::class);

        //brands controller route
        Route::resource('brands',BrandController::class);

        //products controller route
        Route::resource('products',ProductController::class);
        Route::get('products/get-products', [ProductController::class, 'getProducts'])->name('product.related-product');

        // ShippingCharge controller route
        Route::resource('shipping',ShippingChargeController::class,);

        //product subcategory controller route
        Route::get('products-subcategory',[ProductSubCategoryController::class,'getSubCat'])->name('product_subcategory');

        // discount controller route
        Route::resource('discount',DiscountCouponController::class);

        // order controller route
        Route::get('order',[OrderController::class,'order'])->name('admin.order');
        Route::get('order-details/{id}',[OrderController::class,'orderDetails'])->name('admin.orderDetails');
        Route::post('change-order-status/{id}',[OrderController::class,'changeOrderStatus'])->name('admin.changeOrderStatus');
        Route::post('send-email/{id}',[OrderController::class,'sendInvoiceEmail'])->name('admin.sendInvoiceEmail');

        // user controller route
        Route::resource('users',UserController::class);

        // page controller route
        Route::resource('pages',PageController::class);

        // setting controller route
        Route::get('change-password',[SettingController::class,'changeAdminPassword'])->name('admin.changeAdminPassword');
        Route::post('process-admin-change-password',[SettingController::class,'processAdminChangePassword'])->name('admin.processAdminChangePassword');

        // product rating controller route
        Route::get('rating-index',[ProductRatingController::class,'index'])->name('product.productRating');
        Route::post('change-product-ragint',[ProductRatingController::class,'changePorductRating'])->name('product.changePorductRating');

    });
});
