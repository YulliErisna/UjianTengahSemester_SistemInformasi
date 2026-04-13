<?php

// backend/routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController; // Controller baru untuk web
use App\Http\Controllers\Auth\AuthenticatedSessionController; // Controller baru untuk web
use App\Http\Controllers\HomeController; // Controller baru untuk web

// ... (rute-rute yang sudah kita bahas sebelumnya) ...

Route::get('/dashboard', [HomeController::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('/register', [RegisteredUserController::class, 'create'])
            ->middleware('guest')
            ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware('guest');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
            ->middleware('guest')
            ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->middleware('auth')
            ->name('logout');