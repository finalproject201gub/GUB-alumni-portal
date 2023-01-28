<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::group(['as' => 'public.'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/profile', function () {
        return view('public.profile.index');
    })->name('profile');
});

require __DIR__ . '/auth.php';
