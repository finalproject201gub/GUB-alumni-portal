<?php

use App\Http\Controllers\Backend\AdminJobBoardController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Frontend\EventController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\JobBoardController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';


Route::group(['middleware' => 'auth'], function () {

    Route::group(['as' => 'public.'], function () {
        Route::get('/', [HomeController::class, 'index'])
            ->where('any', '.*');
        // ->name('index');

        Route::get('/profile', function () {
            return view('public.profile.index');
        })->name('profile');

        Route::resource('/events', EventController::class);

        Route::resource('/jobs', JobBoardController::class);

    });


    Route::group(['prefix' => 'admin'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        //Events
        Route::resource('/events', \App\Http\Controllers\Backend\EventController::class);

        // Job Board
        Route::resource('/job-board', AdminJobBoardController::class);
    });


});


