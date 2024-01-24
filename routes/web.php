<?php

use App\Models\City;
use App\Models\State;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Payment\AamarPayController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\VatSettingController;
use App\Http\Controllers\UpdateStatusController;
use App\Http\Controllers\YoutubeVideoUploadTestingController;
use Module\CourseManagement\Models\CourseLesson;

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

Auth::routes(['register' => false]);


Route::group(['middleware' => 'auth'], function () {


    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/home', function () {
        return redirect()->route('home');
    });


    Route::match(['GET', 'POST'], 'youtube-video-upload-testings/upload', [YoutubeVideoUploadTestingController::class, 'upload'])->name('youtube-video-upload-testings.upload');

    Route::post('update-status/{table}', UpdateStatusController::class)->name('update-status');

    Route::get('fetch-states', function () {
        try {
            return response()->json([
                'status'    => 1,
                'message'   => 'Success',
                'states'    => State::where('country_id', request('country_id'))->orderBy('name', 'ASC')->get(['id', 'name']),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    => 1,
                'message'   => $th->getMessage(),
                'states'    => [],
            ]);
        }
    })
        ->name('fetch-states');


    Route::get('fetch-cities', function () {
        try {
            return response()->json([
                'status'    => 1,
                'message'   => 'Success',
                'cities'    =>  City::query()
                    ->when(request()->filled('country_id'), fn ($q) => $q->where('country_id', request('country_id')))
                    ->when(request()->filled('state_id'), fn ($q) => $q->where('state_id', request('state_id')))
                    ->orderBy('name', 'ASC')
                    ->get(['id', 'name']),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    => 1,
                'message'   => $th->getMessage(),
                'cities'    => [],
            ]);
        }
    })
        ->name('fetch-cities');





    /*
    |--------------------------------------------------------------------------
    | Country
    |--------------------------------------------------------------------------
    */
    Route::resource('country', CountryController::class);





    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */
    Route::resource('state', StateController::class);





    /*
    |--------------------------------------------------------------------------
    | City
    |--------------------------------------------------------------------------
    */
    Route::resource('city', CityController::class);





    /*
    |--------------------------------------------------------------------------
    | Vat settings
    |--------------------------------------------------------------------------
    */
    Route::match(['GET', 'POST'], 'vat-settings', VatSettingController::class)->name('vat-settings');


    Route::get('test', function() {
        // Storage::disk('google')->put('test.txt', 'Hello World');
    });
});






Route::get('payment',   [AamarPayController::class, 'index']);
Route::post('success',  [AamarPayController::class, 'success'])->name('success');
Route::post('fail',     [AamarPayController::class, 'fail'])->name('fail');
Route::get('cancel',   [AamarPayController::class, 'cancel'])->name('cancel');
