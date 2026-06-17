<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\ShippingChargeController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SubCategoryController;


use App\Models\Product;

// Route::get('/', [FrontendController::class, 'index'])->name('index');
// web.php


// ///////////////////
// Route::get('/productDetails', [FrontendController::class, 'ProductDetails'])->name('productDetails');


Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/dashboard', [FrontendController::class, 'index'])->name('frontentdashboard');
Route::get('/allProducts', [FrontendController::class, 'allProducts'])->name('allProducts');
// Route::post('/login', [AuthController::class, 'loginCheck'])->name('logincheck');
Route::get('/userregister', [FrontendController::class, 'RegisterPage'])->name('userregister');
// Route::get('/userlogin', [FrontendController::class, 'LoginPage'])->name('userlogin');


Route::get('/login', [FrontendController::class, 'LoginPage'])->name('login');
Route::post('/login', [AuthController::class, 'loginCheck'])->name('logincheck');
Route::any('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');

Route::post('/send-email-otp', [AuthController::class, 'sendEmailOtp'])->name('send.email.otp');
Route::post('/verify-email-otp', [AuthController::class, 'verifyEmailOtp'])->name('verify.email.otp');

Route::get('forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');

Route::post('/forgot/send-otp', [AuthController::class, 'sendForgotOtp'])->name('forgot.otp');
Route::post('/forgot/verify-otp', [AuthController::class, 'verifyForgotOtp'])->name('forgot.verify');
Route::post('/forgot/reset-password', [AuthController::class, 'resetPassword'])->name('forgot.reset');


Route::post('/contact-submit', [AuthController::class, 'submit'])->name('contact.submit');
// Toggle wishlist route

Route::get('/fetch-products', [FrontendController::class, 'fetchProducts'])->name('fetchProducts');
Route::get('/most-fetch-products', [FrontendController::class, 'mostfetchProducts'])->name('mostfetchProducts');

Route::get('/product/{id}', [FrontendController::class, 'productDetails'])->name('productDetails');
Route::post('/register-store', [AuthController::class, 'registerStore'])->name('register.store');
Route::get('add-to-wishlist/{id}', [FrontendController::class, 'addToWishlist'])->name('addto.wishlist');
Route::get('/wishlist/remove/{id}', [FrontendController::class, 'removeWishlist'])->name('wishlist.remove');
Route::get('wishlist', [FrontendController::class, 'wishlistList'])->name('show.wishlist.list');
Route::get('/toggle-wishlist/{id}', [FrontendController::class, 'toggleWishlist'])->name('toggle-wishlist');
Route::get('/wishlist-data', [FrontendController::class, 'getWishlist'])->name('get.wishlist');
Route::get('/wishlistpage', [FrontendController::class, 'WishListPage'])->name('wishlistpage');
Route::get('/newarive', [FrontendController::class, 'NewArive'])->name('newarive');
Route::get('/products', [FrontendController::class, 'Products'])->name('productsfilter');
Route::get('/ajax/new-arrivals', [FrontendController::class, 'getNewArrivals'])->name('getarrivals');
Route::get('/about', [FrontendController::class, 'About'])->name('about');
Route::get('/filter-products', [FrontendController::class, 'filterProducts'])->name('filter.products');
Route::get('/products/discount', [FrontendController::class, 'discountProducts'])
    ->name('products.discount');
Route::get('/faq', [FrontendController::class, 'FAQ'])->name('faq');
Route::get('/contact', [FrontendController::class, 'Contact'])->name('contact');
Route::get('/privacy', [FrontendController::class, 'privacy'])->name('privacy');
Route::get('/shipping', [FrontendController::class, 'shipping'])->name('shipping');
Route::get('/terms', [FrontendController::class, 'terms'])->name('terms');
Route::get('/return', [FrontendController::class, 'return'])->name('return');

Route::middleware(['auth'])->group(function () {

    Route::post('/cart/store', [FrontendController::class, 'CartStore'])->name('cart.store');
    Route::get('/cart', [FrontendController::class, 'Cart'])->name('cart');
    Route::get('/cart/items', [FrontendController::class, 'getCartItems'])->name('cart.items');
    Route::get('/sidebar_cart/items', [FrontendController::class, 'getSidebarCartItems'])->name('sidecart.items');
    Route::delete('/cart/remove/{id}', [FrontendController::class, 'removeCartItem'])->name('cart.remove');
    Route::post('/cart/update', [FrontendController::class, 'updateCart'])->name('cart.update');
    Route::get('/checkout', [FrontendController::class, 'CheckOut'])->name('checkout');
    Route::post('/calculate-gst', [FrontendController::class, 'calculateGST']);
    // Address
    Route::post('/save-address', [FrontendController::class, 'AddressStore'])->name('saveAddress');
    Route::get('/get-addresses', [FrontendController::class, 'getAddresses'])->name('get.addresses');
    Route::get('/address/{id}', [FrontendController::class, 'getSingleAddress']);
    Route::post('/update-address/{id}', [FrontendController::class, 'updateAddress']);
    Route::delete('/delete-address/{id}', [FrontendController::class, 'deleteAddress']);
    Route::get('/userdashboard', [FrontendController::class, 'UserDashboard'])->name('userdashboard');
    Route::get('/get-user', [AuthController::class, 'getUser']);
    Route::post('/update-user', [AuthController::class, 'updateUser']);
    Route::post('/order/store', [FrontendController::class, 'OrderStore'])->name('order.store');
    Route::post('payment-process', [FrontendController::class, 'paymentProcess'])->name('payment.process');
    Route::post('/razorpay/create-order', [FrontendController::class, 'razorpayCreateOrder'])
        ->name('razorpay.createOrder');
    Route::post('/order/create-initial', [OrderController::class, 'createInitial'])->name('order.create.initial');
    Route::get('/select-payment/{order_id}', [OrderController::class, 'selectPayment']);
    Route::get('/payment/cod/{order_id}', [OrderController::class, 'cashOnDelivery']);
    Route::get('/payment/razorpay/{order_id}', [OrderController::class, 'razorpayPayment']);
    Route::post('/payment/razorpay/verify', [OrderController::class, 'razorpayVerify'])->name('razorpay.verify');
    Route::get('/select-payment/{order}', [OrderController::class, 'show'])->name('select-payment');
    Route::post('/payment/save', [OrderController::class, 'savePayment'])->name('payment.save');
    Route::get('/myorderuser', [FrontendController::class, 'MyOrderUser'])
        ->middleware('auth')
        ->name('myorderuser');
    Route::get('/orders/list', [App\Http\Controllers\OrderController::class, 'list'])->name('orders.list');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/return', [OrderController::class, 'return'])->name('orders.return');
    Route::post('/review/store', [OrderController::class, 'ReviewStore'])->name('review.store');
    Route::post('/apply-coupon', [OrderController::class, 'applyCoupon'])->name('coupon.apply');
    Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice'])
        ->name('orders.invoice');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminController::class, 'login'])->name('login.submit');


    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/product/edit/{id}', [ProductController::class, 'ProductEdit'])->name('product.edit');
        Route::post('/product/update/{id}', [ProductController::class, 'ProductUpdate'])->name('product.update');
        Route::delete('/product/delete/{id}', [ProductController::class, 'deleteProduct'])->name('product.delete');
        Route::any('/addProductspage', [ProductController::class, 'addProductsPage'])->name('addProductspage');
        Route::post('/add-products', [ProductController::class, 'store'])->name('addProducts');
        Route::get('/myorder', [AdminController::class, 'MyOrder'])->name('myorder');
        Route::get('/userlist', [AdminController::class, 'UserList'])->name('userlist');
        Route::get('/coupon', [AdminController::class, 'coupon'])->name('coupon.index');
        Route::any('/couponadd', [AdminController::class, 'CouponStore'])->name('coupon.store');

        Route::get('/coupon/edit/{id}', [AdminController::class, 'CouponEdit']);
        Route::post('/coupon/update/{id}', [AdminController::class, 'CouponUpdate']);
        Route::post('/coupon/delete/{id}', [AdminController::class, 'CouponDestroy']);
        Route::get('/orders', [AdminController::class, 'OrderList'])->name('orders');
        Route::post('/orders/update-status/{id}', [AdminController::class, 'updateOrderStatus'])->name('orders.updateStatus');
        Route::get('/reviews', [AdminController::class, 'ReviewList'])->name('productreviews');
        Route::resource('category', CategoryController::class);
        Route::resource('material', MaterialController::class);
        Route::resource('subcategory', SubCategoryController::class);
        Route::resource('banner', BannerController::class);
        Route::resource('colors', ColorController::class);
        Route::resource('sizes', SizeController::class);
        Route::resource('shipping', ShippingChargeController::class);

        // Route::get('/shipping', [ShippingChargeController::class, 'index'])->name('admin.shipping.index');
        // Route::post('/shipping/store', [ShippingChargeController::class, 'store'])->name('admin.shipping.store');
        // Route::put('/shipping/update/{id}', [ShippingChargeController::class, 'update'])->name('admin.shipping.update');


        Route::get('/products_list', [ProductController::class, 'fetchProducts'])->name('fetchProductslist');

        Route::get('orders/invoice/{id}', [AdminController::class, 'invoice'])
    ->name('orders.invoice');

    Route::get('/enquiry', [AdminController::class, 'enquiry'])->name('enquiry');
    Route::delete('/enquiry/delete/{id}', [AdminController::class, 'deleteEnquiry'])->name('enquiry.delete');
    Route::get('/get-subcategories/{id}',[ProductController::class, 'getSubCategories'])->name('getSubCategories');
    
    });
});