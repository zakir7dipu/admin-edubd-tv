<?php

use App\Http\Controllers\API\V1\Auth\AuthAPIController;
use App\Http\Controllers\API\V1\DashboardController;
use App\Http\Controllers\API\V1\PaymentMethodController;
use App\Http\Controllers\API\V1\VatSettingController;
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

Route::group(['prefix' => 'v1'], function () {
    /*
    |--------------------------------------------------------------------------
    | PUBLIC API ROUTES
    |--------------------------------------------------------------------------
    */
    Route::post('login', [AuthAPIController::class, 'login']);
    Route::post('login-phone', [AuthAPIController::class, 'loginPhone']);
    Route::post('register', [AuthAPIController::class, 'register']);
    Route::post('register-phone', [AuthAPIController::class, 'registerPhone']);
    Route::post('phone-check', [AuthAPIController::class, 'phoneCheck']);
    Route::post('email-check', [AuthAPIController::class, 'emailCheck']);
    Route::post('google-signin', [AuthAPIController::class, 'GoogleSignIn']);
    Route::post('account/verify/{verify_token}/{hash_email}', [AuthAPIController::class, 'accountVerify']);
    Route::post('account/forgot-password/{phone}', [AuthAPIController::class, 'forgotPassword']);
    Route::post('/account/reset-password/{phone}', [AuthAPIController::class, 'resetPassword']);
    Route::put('/verify-otp-forgot/{phone}', [AuthAPIController::class, 'verifyOtp']);
    Route::put('verify-otp/{phone}', [AuthAPIController::class, 'verifyOtp']);
    Route::put('resend-otp/{phone}', [AuthAPIController::class, 'resendOtp']);


    // Route::get('login/facebook', 'Auth\LoginController@redirectToFacebookProvider');
    // Route::get('login/facebook/callback', 'Auth\LoginController@handleFacebookProviderCallback');
    Route::get('login/google', [AuthAPIController::class, 'redirectToGoogleProvider']);
    Route::get('login/google/callback',  [AuthAPIController::class, 'handleGoogleProviderCallback']);





    /*
    |--------------------------------------------------------------------------
    | PRIVATE API ROUTES
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('payment-methods', PaymentMethodController::class);
        Route::get('vat-percentage', VatSettingController::class);
        Route::post('logout', [AuthAPIController::class, 'logout']);

        Route::group(['prefix' => 'account'], function () {
            Route::get('dashboard-countings', DashboardController::class);
        });
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
