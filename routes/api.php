<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogCommentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::fallback(function(){
    return response()->json([
        'code'  => 404,
        'message' => 'Page Not Found. If error persists, contact khanhhoang@website.com'], 404);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);

Route::get('/category', [CategoryController::class, 'index']);
Route::post('/order', [OrderController::class, 'index']);
Route::get('/payment', [PaymentTypeController::class, 'index']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products_discount', [ProductController::class, 'discount']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/topsell', [ProductController::class, 'getTopSell'])->middleware('handle-query');

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/orders', [OrderController::class, 'index'])->middleware('jwt.auth');
Route::get('/payments', [PaymentTypeController::class, 'index']);

Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog-category', [BlogCategoryController::class, 'index']);

// Blogs
Route::get('/blogs', [BlogController::class, 'index'])->middleware('handle-query');
Route::get('/blogs/blog-categories/{id}', [BlogController::class, 'blogsByCategoryId'])->middleware('handle-query');
Route::get('/blogs/{id}', [BlogController::class, 'show']);
Route::get('/blogs-comments/{blog_id}', [BlogCommentController::class, 'show'])->middleware('handle-query');
Route::get('/blogs-comments/{blog_id}/{parent_id}', [BlogCommentController::class, 'detail']);
Route::post('/blogs-comments', [BlogCommentController::class, 'store']);
Route::get('/blogs-categories', [BlogCategoryController::class, 'index']);

Route::post('auth/register', [CustomerController::class, 'register']);
Route::post('auth/login', [CustomerController::class, 'login']);
Route::post('auth/login-google', [CustomerController::class, 'loginOrRegisterByGoogle']);

Route::get('/customers', [CustomerController::class, 'show'])->middleware('jwt.auth');
Route::get('/addresses/{user_id}', [AddressController::class, 'show'])->middleware('jwt.auth');
Route::get('/address/default', [AddressController::class, 'default'])->middleware('jwt.auth');

Route::get('/orders', [OrderController::class, 'getListOrders'])->middleware('jwt.auth')->middleware('handle-query');

Route::group([
    'middleware' => ['jwt.auth', 'verify-jwt'],
], function () {
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::put('/customers', [CustomerController::class, 'update']);
    Route::put('/addresses/{id}/default', [AddressController::class, 'setDefault']);
    Route::put('/addresses/{id}', [AddressController::class, 'update']);
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy']);
    // payment MOMO
    Route::post('/checkout', [CheckoutController::class, 'createPayment'])->name('checkout.createPayment');
});

Route::post('/warehouse', [WarehouseController::class, 'index']);
Route::get('/vouchers', [VoucherController::class, 'index']);
Route::post('/voucher', [VoucherController::class, 'store']);

Route::post('reset-password', [ResetPasswordController::class, 'sendMail']);
Route::put('reset-password/{token}', [ResetPasswordController::class, 'reset']);


Route::get('/queue', function () {
    $exitCode = Artisan::call('queue:work --stop-when-empty', []);

    return 'Queue started.';
});

Route::get('/reviews', [ProductController::class, 'reviews']);
Route::post('/reviews', [ProductController::class, 'storeReviews']);



