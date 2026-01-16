<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\RedirectByRoleController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    // Central post-login redirect

    Route::get('/dashboard', RedirectByRoleController::class)->name('dashboard');

});

// SuperAdmin routes

Route::middleware(['auth', 'role:super_admin'])->group(function () {

    Route::get('/superadmin', [DashboardController::class, 'index'])
        ->name('superadmin.dashboard');
});

// Admin routes

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');
});

// Member routes

Route::middleware(['auth', 'role:member'])->group(function () {

    Route::get('/member', [MemberDashboardController::class, 'index'])
        ->name('member.dashboard');

});
