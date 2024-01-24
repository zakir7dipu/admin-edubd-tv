<?php

use Illuminate\Support\Facades\Route;
use Module\UserAccess\Controllers\AdminController;
use Module\UserAccess\Controllers\ChangePasswordController;
use Module\UserAccess\Controllers\UserPermissionController;

Route::group(['prefix' => 'user-access', 'as' => 'ua.'], function () {
    Route::resource('admin', AdminController::class);

    Route::get('change-password',                       [ChangePasswordController::class,  'index']                            )->name('user.change_password');
    Route::post('change-password-update',               [ChangePasswordController::class,  'update']                           )->name('user.change_password.update');

    Route::resource('parent-permissions', 'ParentPermissionController');
    Route::resource('modules', 'ModuleController');
    Route::get('active-deactive-module/{module}', 'ModuleController@activeDeactive')->name('active.deactive.module');
    Route::resource('submodules', 'SubmoduleController');
    Route::resource('permissions', 'PermissionController');

    Route::resource('permission-access',UserPermissionController::class);

    // Route::resource('permission-access', 'UserPermissionController');
    Route::get('permission-access/create/{id}', 'UserPermissionController@index')->name('load.existing.users.permission');
    Route::get('select/employee/list', 'UserPermissionController@employee_list')->name('employee_list');
    Route::get('permitted/employee/list', 'UserPermissionController@permittedEmployeeList')->name('permitted.employee.list');

    Route::get('permission-access-employee', 'UserPermissionController@employeePermission')->name('permission-access.employee');
    Route::post('permission-access-employee', 'UserPermissionController@employeePermissionStore')->name('permission-access.employee.store');
});




Route::get('setting/view-permitted-users', 'PermissionController@view_permitted_users')->name('permitted.users');
Route::get('user/{id}/status/{status}', 'PermissionController@userChangeStatus')->name('user.active.deactive');
Route::delete('setting/permitted-users/delete/{user}', 'PermissionController@permittedUserDelete')->name('permitted.user.delete');
Route::get('/permitted-users/{id}/edit', 'UserPermissionController@edit')->name('edit.permitted.users');
Route::put('/update-permitted/{id}/users', 'UserPermissionController@update')->name('update.permission.access');
