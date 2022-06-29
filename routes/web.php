<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [FrontendController::class, 'index'])->name('front.index');
Route::post('/index-process', [FrontendController::class, 'indexProcess'])->name('index.process');
Route::get('/checkout', [FrontendController::class, 'checkout'])->name('front.checkout');
Route::post('/stripe-checkout-process', [StripeController::class, 'stripeCheckoutProcess'])->name('stripe.checkout.process');

Route::post('/checkout-process', [FrontendController::class, 'checkoutProcess'])->name('checkout.process');
Route::get('/summary/{order}', [FrontendController::class, 'summary'])->name('checkout.summary');

Route::get('/home', function(){
    return redirect()->route('front.index');
})->name('home');

Auth::routes();

Route::get('/admin', function(){
    return redirect()->route('admin.login');
});

Route::get('/login', function(){
    return redirect()->route('admin.login');
});


Route::get('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login');
Route::post('/login-process', [LoginController::class,'loginProcess'])->name('login.process');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('user.dashboard');//->middleware('verified');
Route::middleware(['auth', 'verified'])->name('general.')->group(function(){
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/update-profile-process', [UserController::class, 'updateProfileProcess'])->name('update.profile.process');
    Route::post('/change-password-process', [UserController::class, 'changePasswordProcess'])->name('change.password.process');
    Route::post('/change-picture-process', [UserController::class, 'changePictureProcess'])->name('change.picture.process');
});

Route::middleware(['auth', 'verified'])->name('admin.')->group(function(){
    Route::resource('products', ProductController::class);
    Route::post('/update-status', [ProductController::class, 'updateStatus'])->name('products.update.status');

    Route::resource('orders', OrderController::class);
});

Route::get('/front-home', function(){
    return redirect()->route('admin.login');
})->name('front.home');

Route::post('/create-slug', [ProductController::class, 'createSlug'])->name('create.slug');
Route::get('/about-cvv', [FrontendController::class, 'aboutCvv'])->name('about.cvv');
Route::get('/terms-and-conditions', [FrontendController::class, 'terms'])->name('terms');
Route::get('/privacy-policy', [FrontendController::class, 'privacy'])->name('privacy');
Route::get('/contact-us', [FrontendController::class, 'contactUs'])->name('contact.us');