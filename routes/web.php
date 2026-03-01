<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProductVariantsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Dashboard\VariantOptionsController;
use App\Http\Controllers\Dashboard\VariantsController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

// Route::middleware('auth')->group(function () {
//     Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
//     Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
// });

// Route::get('index',function(){
//     return view('index');
// });

// Route::prefix('dashboard')
//     ->name('dashboard.')
//     ->group(function () {
//         Route::resource('products', ProductController::class);
//     });
//     Route::resource('products.variants', controller: ProductVariantsController::class);

//     Route::prefix('dashboard')
//     ->name('dashboard.')
//     ->group(function () {
//     Route::resource('variants', controller: VariantsController::class);
//     });
//     Route::prefix('dashboard')
//     ->name('dashboard.')
//     ->group(function () {
//         Route::resource('productvariants', ProductVariantsController::class);
//         Route::resource('variant-options', VariantOptionsController::class);

//     });


// Route::prefix('dashboard')
//     ->name('dashboard.')
//     ->group(function () {
//         Route::resource('categories', CategoryController::class);
//     });


//     Route::get('/login',[AuthController::class,'loginForm'])->name('login');
//     Route::post('/login',[AuthController::class,'login'])->name('login.submit');
//     Route::get('/register',[AuthController::class,'registerForm'])->name('register');
//     Route::post('/register',[AuthController::class,'register'])->name('register.submit');
//     Route::get('/forget',[AuthController::class,'forgetPasswordForm'])->name('forget');
//     Route::post('/forget',[AuthController::class,'ForgetPassword'])->name('forget.password.submit');
//     Route::get('/verify-code',[AuthController::class,'verifyCodeForm'])->name('verify.code');
//     Route::post('/verify-code',[AuthController::class,'verifyCode'])->name('verify.code.submit');
//     Route::get('/reset-password',[AuthController::class,'resetPasswordForm'])->name('reset.password');
//     Route::post('/reset-password',[AuthController::class,'resetPassword'])->name('reset.password.submit');

//     Route::get('/logout', [AuthController::class,'logout'])->name('logout');
//     Route::get('/profile', [AuthController::class,'profile'])->name('profile');

//     Route::get('updateprofile', [AuthController::class,'updateProfileForm'])->name('profile.update.form');
//     Route::put('updateprofile', [AuthController::class,'updateProfile'])->name('profile.update');

//     Route::get('/', [UserProductController::class, 'index'])->name('products.index');

//     Route::middleware(['auth.custom'])->group(function () {

    
//     Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
//     Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    
//     Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
//     Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
//     Route::delete('/cart/item/{id}', [CartController::class, 'remove'])->name('cart.remove');
//     Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

// });
// Route::delete(
//     'dashboard/variant-options/{id}',
//     [VariantOptionsController::class, 'destroy']
// )->name('dashboard.variant-options.destroy');
// Route::get('/checkout', [CheckoutController::class, 'index'])
//     ->name('checkout.index')
//     ->middleware('auth');

// Route::post('/checkout', [CheckoutController::class, 'store'])
//     ->name('checkout.store')
//     ->middleware('auth');


    Route::get('/', [UserProductController::class, 'index'])->name('products.index');

    Route::middleware(['setlocale'])->group(function(){
        Route::get('lang/{locale}',function($locale){
        if(in_array($locale,['en','ar'])){
            session(['locale'=> $locale]);
        }
        return redirect()->back();
        });
    });
        
    

Route::middleware(['auth'])->group(function () {

    // My Orders
    Route::get('/my-orders', [OrderController::class, 'index'])
        ->name('orders.index');
        // ->middleware('permission:orders.view');

    Route::get('/my-orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');
        // ->middleware('permission:orders.view');

    // Profile
    Route::get('/profile', [AuthController::class,'profile'])->name('profile');
    Route::get('updateprofile', [AuthController::class,'updateProfileForm'])->name('profile.update.form');
    Route::put('updateprofile', [AuthController::class,'updateProfile'])->name('profile.update');

     // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/item/{id}', [CartController::class, 'remove'])->name('cart.remove');

});

Route::middleware(['auth', 'permission:orders.create'])->group(function () {

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');
});
Route::prefix('dashboard')
    ->name('dashboard.')
    ->middleware(['auth'])
    ->group(function () {
Route::resource('products', ProductController::class)
    ->middleware('permission:products.view');
// Route::resource('products.variants', ProductVariantsController::class)
//     ->middleware('permission:variants.view');
        Route::resource('productvariants', ProductVariantsController::class);
        Route::resource('variant-options', VariantOptionsController::class);
Route::resource('variants', VariantsController::class)
    ->middleware('permission:variants.view');
Route::resource('variant-options', VariantOptionsController::class)
    ->middleware('permission:variants.view');

Route::delete(
    'variant-options/{id}',
    [VariantOptionsController::class, 'destroy']
)->name('variant-options.destroy');
Route::resource('categories', CategoryController::class)
    ->middleware('permission:categories.view');
Route::resource('orders', OrderController::class)
    ->only(['index', 'show', 'update'])
    ->middleware('permission:orders.view');
}); 



Route::get('/login',[AuthController::class,'loginForm'])->name('login');
Route::post('/login',[AuthController::class,'login'])->name('login.submit');

Route::get('/register',[AuthController::class,'registerForm'])->name('register');
Route::post('/register',[AuthController::class,'register'])->name('register.submit');

Route::get('/forget',[AuthController::class,'forgetPasswordForm'])->name('forget');
Route::post('/forget',[AuthController::class,'ForgetPassword'])->name('forget.password.submit');

Route::get('/verify-code',[AuthController::class,'verifyCodeForm'])->name('verify.code');
Route::post('/verify-code',[AuthController::class,'verifyCode'])->name('verify.code.submit');

Route::get('/reset-password',[AuthController::class,'resetPasswordForm'])->name('reset.password');
Route::post('/reset-password',[AuthController::class,'resetPassword'])->name('reset.password.submit');

Route::get('/logout', [AuthController::class,'logout'])->name('logout');



