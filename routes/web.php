<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\RedirectByRoleController;
use App\Http\Controllers\SuperAdmin\CompanyController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ShortUrlRedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

// Authentication routes

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    // Central post-login redirect

    Route::get('/dashboard', RedirectByRoleController::class)->name('dashboard');

});

// SuperAdmin routes

Route::middleware(['auth', 'role:super_admin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

    // Dashboard

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Company Management

    Route::get('/companies', [CompanyController::class, 'index'])
            ->name('companies.index');

    Route::post('/companies', [CompanyController::class, 'store'])
            ->name('companies.store');

    Route::put('/companies/{company}', [CompanyController::class, 'update'])
            ->name('companies.update');

    Route::delete('/companies/{company}', [CompanyController::class, 'destroy'])
            ->name('companies.destroy');

    Route::get('/companies/{company}', [CompanyController::class, 'show'])
        ->name('companies.show');

    // Company Admins (Secondary Invite Flow)

    Route::get('/companies/{company}/overview',
        [CompanyController::class, 'companyOverview']
    )->name('companies.overview.index');

    Route::get('/companies/{company}/admins',
        [CompanyController::class, 'companyAdmins']
    )->name('companies.admins.index');

    Route::post('/companies/{company}/admins/invite',
        [CompanyController::class, 'inviteCompanyAdmin']
    )->name('companies.admins.invite');

    // Link Management

    Route::get('/links', [LinkController::class, 'index'])
        ->name('links.index');

});

// Invitation acceptance

Route::get('/invitations/{token}', [InvitationController::class, 'show'])->name('invitations.show');

Route::post('/invitations/{token}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');

Route::post('/invitations/{token}/complete', [InvitationController::class, 'complete'])->name('invitations.complete');

// Admin routes

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Dashboard

    Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    // User Management

    Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users.index');

    // Invitation Management

    Route::post('/invitations', [AdminUserController::class, 'inviteUser'])
            ->name('invitations.store');

    // Link Management

    Route::get('/links', [LinkController::class, 'index'])
        ->name('links.index');

    Route::post('/links', [LinkController::class, 'store'])
        ->name('links.store');
});

// Member routes

Route::middleware(['auth', 'role:member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {

    // Dashboard

    Route::get('/', [MemberDashboardController::class, 'index'])
        ->name('dashboard');

    // Link Management

    Route::get('/links', [LinkController::class, 'index'])
        ->name('links.index');

    Route::post('/links', [LinkController::class, 'store'])
        ->name('links.store');

});

// Short URL redirection route

Route::middleware('throttle:60,1')->get('/{code}', ShortUrlRedirectController::class)
    ->where('code', '[A-Za-z0-9]+');
