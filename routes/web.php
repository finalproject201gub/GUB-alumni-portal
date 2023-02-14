<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

require __DIR__ . '/auth.php';


Route::group(['middleware' => 'auth'], function () {

    Route::group(['as' => 'public.'], function () {
        Route::get('/', [HomeController::class, 'index'])->name('index');

        Route::get('/profile', function () {
            return view('public.profile.index');
        })->name('profile');

        Route::resource('/events', \App\Http\Controllers\Frontend\EventController::class);

    });


    Route::group(['prefix' => 'admin'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


        // Job Board
//        Route::resource('job-board');
    });


});


