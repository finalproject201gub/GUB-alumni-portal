<?php

use App\Http\Controllers\Api\CreatePostApiController;
use App\Http\Controllers\Api\DeletePostApiController;
use App\Http\Controllers\Api\PostCommentApiController;
use App\Http\Controllers\Api\PostCommentController;
use App\Http\Controllers\Api\PostsApiController;
use App\Http\Controllers\Api\StaticDataForHomePageApiController;
use App\Http\Controllers\Api\UpdatePostApiController;
use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
use App\Http\Controllers\Backend\AdminJobBoardController;
use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\CustomAuthenticateRedirectController;
use App\Http\Controllers\Frontend\EventController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\JobBoardController;
use App\Http\Controllers\Frontend\LikeController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';


Route::group(['middleware' => 'auth'], function () {

    Route::group(['as' => 'public.'], function () {
        Route::get('/', [HomeController::class, 'index'])
            ->where('any', '.*');
        // ->name('index');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/profile/{user_id}/', [ProfileController::class, 'update']);

        Route::resource('/events', EventController::class);

        Route::resource('/jobs', JobBoardController::class);
        Route::get('/jobs/{id}/apply', [JobBoardController::class, 'applyJobView']);
        Route::post('/job/apply', [JobBoardController::class, 'applyJob']);

    });


    Route::group(['middleware' => 'checkRole:Admin'], function () {
        Route::group(['prefix' => 'admin'], function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            //Events
            Route::resource('/events', \App\Http\Controllers\Backend\EventController::class);

            Route::get('/posts', [PostController::class, 'index']);
            Route::get('/posts/{id}', [PostController::class, 'edit']);
            Route::put('/posts/{id}', [PostController::class, 'update']);
            Route::delete('/posts/{id}', [PostController::class, 'destroy']);


            // Job Board
            Route::resource('/job-board', AdminJobBoardController::class);

            Route::group(['prefix' => 'users'], function () {
                Route::get('/', [AdminUserController::class, 'index']);
                Route::get('/view/{id}', [AdminUserController::class, 'view']);
                Route::get('/edit/{id}', [AdminUserController::class, 'edit']);
                Route::put('/{id}', [AdminUserController::class, 'update']);
            });
        });
    });

    Route::group(['middleware' => 'checkRole:Alumni'], function () {
        Route::group(['prefix' => 'backend/alumni'], function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/job-board/applicants', [AdminJobBoardController::class, 'applicantsIndex']);
            Route::resource('/job-board', AdminJobBoardController::class);
            Route::get('/download-applicants-cv/', [AdminJobBoardController::class, 'downloadCV']);
        });
    });

    Route::group(['middleware' => 'checkRole:Student'], function () {
        Route::group(['prefix' => 'backend/student'], function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        });

    });

    Route::prefix('api/v1')->group(function () {
        Route::group(['prefix' => 'posts'], function () {
            Route::get('/', PostsApiController::class);
            Route::put('/{id}', UpdatePostApiController::class);
            Route::delete('/{id}', DeletePostApiController::class);
            Route::post('store', CreatePostApiController::class);
            Route::post('/{post}/like-insert-delete', [LikeController::class, 'likeInsertDeleteToPost']);

            //comment routes
            Route::prefix('comments')->group(function () {
                Route::get('/{postId}', PostCommentApiController::class);
                Route::post('/{postId}', [PostCommentController::class, 'store']);
                Route::put('/{id}', [PostCommentController::class, 'update']);
                Route::delete('/{id}', [PostCommentController::class, 'destroy']);

                Route::post('/{commentId}/like-insert-delete', [LikeController::class, 'likeInsertDeleteToComment']);
            });
        });

        Route::get('/static-data-for-home-page', StaticDataForHomePageApiController::class);

        Route::get('/notifications/unread', [NotificationController::class, 'getUnreadNotifications']);

        Route::get('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);
    });
});

Route::get("/redirectAuthenticatedUsers", [RedirectAuthenticatedUsersController::class, "home"]);


Route::get('/custom-authenticate-redirect', [CustomAuthenticateRedirectController::class, 'showMessageAndRedirect']);

