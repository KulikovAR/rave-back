<?php

use App\Http\Controllers\Auth\AuthSessionController;
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
| Get csrf token if front on same domain:
| GET|HEAD  sanctum/csrf-cookie
|
*/

Route::get('/', function () {
	return view('app');
});

Route::post('/login/session', [AuthSessionController::class, 'store'])->name('login.stateful');

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/logout/session', [AuthSessionController::class, 'destroy'])->name('logout.stateful');
});
