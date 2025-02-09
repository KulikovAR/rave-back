<?php

use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\ServiceScheduleController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/verify', [AuthController::class, 'verify'])->name('auth.verify');

    Route::middleware('refresh')->group(function () {
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::get('/assets/{locale?}', [AssetsController::class, 'show'])->name('assets.index');

Route::apiResource('restaurants', RestaurantController::class)->except(['show']);
Route::get('/restaurants/{slug}', [RestaurantController::class, 'show']);
Route::apiResource('categories', CategoryController::class)->except(['show']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);
Route::apiResource('products', ProductController::class)->except(['show']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::apiResource('banners', BannerController::class);
Route::apiResource('settings', SettingController::class);

Route::get('products/{slug}/recommended', [ProductController::class, 'getRecommended']);
Route::get('products-by-rest/{slug}', [ProductController::class, 'getProductsByRest']);
Route::post('orders', [OrderController::class, 'store']);
Route::get('orders', [OrderController::class, 'index']);
Route::get('orders/{id}', [OrderController::class, 'show']);

Route::get('/service_schedule/{restaurantId}', [ServiceScheduleController::class, 'index']);
Route::get('/service_schedule_by_slug/{slug}', [ServiceScheduleController::class, 'getBySlug']);
Route::put('/service_schedule/{id}', [ServiceScheduleController::class, 'update']);
