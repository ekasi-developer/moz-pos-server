<?php

use App\Http\Controllers\Api\AccountsController;
use App\Http\Controllers\Api\Authentication\LoginController;
use App\Http\Controllers\Api\Authentication\LogoutController;
use App\Http\Controllers\Api\Payment\MobilePaymentController;
use App\Http\Controllers\Api\Payment\PaymentController;
use App\Http\Controllers\Api\TransactionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('authentication')->group(function () {
    Route::controller(LoginController::class)->middleware(['auth.guest'])->group(function () {
        Route::post('login', 'index');
    });
    Route::controller(LogoutController::class)->middleware(['auth:api'])->group(function () {
        Route::post('logout', 'index');
    });
});

Route::prefix('accounts')->middleware('auth:api')->controller(AccountsController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
});

Route::prefix('payment')->group(function () {
    Route::prefix('mobile')->controller(MobilePaymentController::class)->middleware(['auth:api'])->group(function () {
        Route::post('/', 'store');
    });
});

Route::prefix('transactions')->middleware(['auth:api'])->controller(TransactionsController::class)->group(function () {
    Route::get('/', 'index');
    Route::prefix('{transaction}')->group(function () {{
        Route::get('/', 'show');
        Route::delete('/', 'destroy');
    }});
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
