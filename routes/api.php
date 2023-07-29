<?php

use App\Http\Controllers\AirportsController;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\Auth\AuthProviderController;
use App\Http\Controllers\Auth\AuthTokenController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\VerificationContactController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\Partners\PartnerMessageController;
use App\Http\Controllers\Partners\PromoCodeController;
use App\Http\Controllers\Partners\TakeOutController;
use App\Http\Controllers\PassengersController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SearchFlightController;
use App\Http\Controllers\UserProfileController;
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
    Route::post('/registration/email', [RegistrationController::class, 'emailRegistration'])->name('registration');

    Route::post('/login', [AuthTokenController::class, 'store'])->name('login.stateless');

    Route::post('/password/send', [PasswordController::class, 'sendPasswordLink'])->middleware(['throttle:6,1'])->name('password.send');
    Route::post('/password/reset', [PasswordController::class, 'store'])->name('password.reset');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/verification/email', [VerificationContactController::class, 'sendEmailVerification'])->name('verification.email.send');

    Route::patch('/password', [PasswordController::class, 'update'])->name('password.update');
    Route::delete('/logout', [AuthTokenController::class, 'destroy'])->name('logout.stateless');


    Route::middleware('verified')->group(function () {
        Route::get('/user_profile', [UserProfileController::class, 'index'])->name('user_profile.index');
        Route::post('/user_profile', [UserProfileController::class, 'store'])->name('user_profile.store');

        Route::get('/passengers', [PassengersController::class, 'index'])->name('passengers.index');
        Route::post('/passengers', [PassengersController::class, 'store'])->name('passengers.store');
        Route::put('/passengers', [PassengersController::class, 'update'])->name('passengers.update');
        Route::delete('/passengers', [PassengersController::class, 'destroy'])->name('passengers.destroy');

        Route::delete('/orders', [OrdersController::class, 'destroy'])->name('orders.destroy');


        Route::prefix('partners')->group(function () {
            Route::post('/message', [PartnerMessageController::class, 'store'])->name('partner-message.store');

            Route::get('/takeouts', [TakeOutController::class, 'index'])->name('takeout.index');
            Route::post('/takeouts', [TakeOutController::class, 'store'])->name('takeout.store');

            Route::get('/promocodes', [PromoCodeController::class, 'index'])->name('promocode.index');
            Route::post('/promocodes', [PromoCodeController::class, 'store'])->name('promocode.store');
            Route::put('/promocodes', [PromoCodeController::class, 'update'])->name('promocode.update');
            Route::delete('/promocodes', [PromoCodeController::class, 'destroy'])->name('promocode.destroy');

            Route::get('/credit_card', [CreditCardController::class, 'index'])->name('credit-card.index');
            Route::post('/credit_card', [CreditCardController::class, 'store'])->name('credit-card.store');
            Route::put('/credit_card', [CreditCardController::class, 'update'])->name('credit-card.update');
            Route::delete('/credit_card', [CreditCardController::class, 'destroy'])->name('credit-card.destroy');

            Route::get('/bank', [BankController::class, 'index'])->name('bank.index');
            Route::post('/bank', [BankController::class, 'store'])->name('bank.store');
            Route::put('/bank', [BankController::class, 'update'])->name('bank.update');
            Route::delete('/bank', [BankController::class, 'destroy'])->name('bank.destroy');
        });

    });
});

Route::get('/auth/{provider}/redirect', [AuthProviderController::class, 'redirectToProvider'])->middleware('throttle:10,1')->name('provider.redirect');
Route::get('/auth/{provider}/callback', [AuthProviderController::class, 'loginOrRegister'])->name('provider.callback');

Route::get('/verification/{id}/{hash}', [VerificationContactController::class, 'verifyEmail'])->middleware(['signed', 'throttle:6,1'])->name('verification.email.url');

Route::get('/assets/{locale?}', [AssetsController::class, 'show'])->name('assets.index');

Route::get('/flights', [SearchFlightController::class, 'index'])->name('search-flight');
Route::get('/airports', [AirportsController::class, 'index'])->name('search-airports');

Route::post('/orders', [OrdersController::class, 'store'])->name('orders.store');
Route::put('/orders', [OrdersController::class, 'update'])->middleware(['throttle:60,1'])->name('orders.update');
Route::get('/orders', [OrdersController::class, 'index'])->middleware(['throttle:60,1'])->name('orders.index');

Route::get('/payments/redirect', [PaymentController::class, 'redirect'])->name('payment.redirect');
Route::get('/payments/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payments/failed', [PaymentController::class, 'failed'])->name('payment.failed');
Route::get('/payments/download', [PaymentController::class, 'download'])->name('payment.download');
Route::get('/payments/retry', [PaymentController::class, 'retry'])->name('payment.retry');

