<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('public.index');

require __DIR__ . '/auth.php';
