<?php

use Illuminate\Support\Facades\Route;
use Module\EnrollmentManagement\Controllers\CouponsController;
use Module\EnrollmentManagement\Controllers\EnrollMentController;
use Module\EnrollmentManagement\Controllers\DailyReportController;
use Module\EnrollmentManagement\Controllers\ReportController;

Route::group(['prefix' => 'order-management', 'as' => 'em.'], function () {
    Route::resource('coupon', CouponsController::class);
    Route::resource('enrollment', EnrollMentController::class);
    Route::resource('report',DailyReportController::class);
    Route::resource('report-all',ReportController::class);

});
// Route::get('changeStatus',EnrollMentController::class, 'changeStatus');
// Route::get('changeStatus', 'EnrollMentController@changeStatus');
// Route::get('report', [DailyReportController::class, 'index'])->name('report');

Route::put('/enrollments/{id}/status', [EnrollMentController::class, 'updateStatus'])->name('enrollments.updateStatus');

