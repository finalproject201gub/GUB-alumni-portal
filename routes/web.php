<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostsApiController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\EventController;
use App\Http\Controllers\Api\CreatePostApiController;
use App\Http\Controllers\Api\DeletePostApiController;
use App\Http\Controllers\Api\UpdatePostApiController;
use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
use App\Http\Controllers\Backend\AdminJobBoardController;
use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Frontend\JobBoardController;
use App\Http\Controllers\CustomAuthenticateRedirectController;
use App\Http\Controllers\Api\StaticDataForHomePageApiController;
use App\Http\Controllers\Frontend\ProfileController;

require __DIR__ . '/auth.php';


Route::group(['middleware' => 'auth'], function () {

    Route::group(['as' => 'public.'], function () {
        Route::get('/', [HomeController::class, 'index'])
            ->where('any', '.*');
        // ->name('index');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

        Route::resource('/events', EventController::class);

        Route::resource('/jobs', JobBoardController::class);

    });


    Route::group(['prefix' => 'admin', 'middleware' => 'checkRole:Admin'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        //Events
        Route::resource('/events', \App\Http\Controllers\Backend\EventController::class);

        // Job Board
        Route::resource('/job-board', AdminJobBoardController::class);

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [AdminUserController::class, 'index']);
            Route::get('/view/{id}', [AdminUserController::class, 'view']);
            Route::get('/edit/{id}', [AdminUserController::class, 'edit']);
            Route::put('/{id}', [AdminUserController::class, 'update']);
        });
    });

    Route::group(['prefix' => 'backend/alumni', 'middleware' => 'checkRole:Alumni'], function () {

    });

    Route::group(['prefix' => 'backend/student', 'middleware' => 'checkRole:Student'], function () {

    });

    Route::prefix('api/v1')->group(function () {
        Route::group(['prefix' => 'posts'], function () {
            Route::get('/', PostsApiController::class);
            Route::put('/{id}', UpdatePostApiController::class);
            Route::delete('/{id}', DeletePostApiController::class);
            Route::post('store', CreatePostApiController::class);
        });

        Route::get('/static-data-for-home-page', StaticDataForHomePageApiController::class);
    });
});

Route::get("/redirectAuthenticatedUsers", [RedirectAuthenticatedUsersController::class, "home"]);


Route::get('/custom-authenticate-redirect', [CustomAuthenticateRedirectController::class, 'showMessageAndRedirect']);

