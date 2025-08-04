<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdController,
    AdminDashboardController,
    RequestController,
    UserController,

};

//for super admin
Route::middleware(['auth', 'IsOTPVerified', 'role:superadmin'])->group(function () {

        Route::controller(AdminDashboardController::class)->group(function () {
            Route::get('dashboard', 'create')->name('dashboard');
            Route::post('lineChart', 'lineChart')->name('line-chart');
            Route::post('registrationChart', 'registrationChart')->name('registrationChart');
            Route::post('trafficReport', 'trafficReport')->name('trafficReport');
            Route::get('filter', 'getFilteredData')->name('getFilteredData');
            Route::get('userpassreset', 'resetPasswordRest')->name('userPassReset'); // By Asfia
            Route::post('resetPassword', 'resetPassword')->name('resetPassword'); // By Asfia
            Route::get('filterUsers', 'filterUser')->name('filterUsers'); // By Asfia
        });
        Route::controller(RequestController::class)->group(function () {
            Route::prefix('requests')->name('requests.')->group(function () {
                Route::get('list', 'list')->name('list');
                Route::get('properties', 'properties')->name('properties'); //new route added by Yousaf
                Route::get('details/{id}', 'details')->name('details');
                Route::get('adDetails/{id}', 'adDetails')->name('adDetails'); // By Asfia
                Route::get('ads', 'ads')->name('ads'); // By Asfia
                Route::post('approval', 'requestApproval')->name('approval');
                Route::get('feedbacks', 'feedbacks')->name('feedbacks'); // By Asfia
                Route::post('feedbacks/toggle-status', 'toggleStatus')->name('toggle'); // By Asfia
                Route::get('generalFeedbacks', 'generalFeedbacks')->name('generalFeedbacks'); // By Asfia
                Route::post('generalFeedbacks/toggle-status', 'generalFeedbacksToggleStatus')->name('generalFeedbacksToggle'); // By Asfia
            });
        });

        Route::controller(AdController::class)->group(function () {
            Route::prefix('ads')->name('ads.')->group(function () {
                Route::get('list', 'newAdsList')->name('list');
                Route::get('details/{id}', 'details')->name('details');
                Route::post('approval', 'requestApproval')->name('approval');
            });
        });

        Route::controller(UserController::class)->group(function () {
            Route::prefix('users')->name('users.')->group(function () {
                Route::get('form/{id?}', 'form')->name('form');
                Route::post('add', 'store')->name('add');
                Route::get('list', 'index')->name('list');
            });
        });
    });
