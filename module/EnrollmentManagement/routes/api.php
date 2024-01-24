<?php

use Illuminate\Support\Facades\Route;
use Module\EnrollmentManagement\Controllers\API\V1\CouponController;
use Module\EnrollmentManagement\Controllers\API\V1\EnrollmentController;

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {
    Route::post('coupon-amount', [CouponController::class, 'couponAmount']);
    Route::get('coupon-check/{code}', [CouponController::class, 'couponCheck']);

    Route::group(['prefix' => 'enrollments'], function () {
        Route::get('/', [EnrollmentController::class, 'index']);
        Route::get('{invoice_no}', [EnrollmentController::class, 'show']);
        Route::post('store', [EnrollmentController::class, 'store']);
        Route::put('update/{id}', [EnrollmentController::class, 'update']);
        Route::put('update-app/{id}', [EnrollmentController::class, 'updateApp']);
    });
});
