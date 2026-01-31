<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\FeatureFlagController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/debug', [HomeController::class, 'debug'])->name('debug');

// Admin authentication
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin dashboard
Route::get('/admin/dashboard', [FeatureFlagController::class, 'index'])->name('admin.dashboard');

// Admin feature flags
Route::get('/admin/flags', [FeatureFlagController::class, 'index'])->name('admin.flags.index');
Route::get('/admin/flags/create', [FeatureFlagController::class, 'create'])->name('admin.flags.create');
Route::post('/admin/flags', [FeatureFlagController::class, 'store'])->name('admin.flags.store');
Route::get('/admin/flags/{id}/edit', [FeatureFlagController::class, 'edit'])->name('admin.flags.edit');
Route::put('/admin/flags/{id}', [FeatureFlagController::class, 'update'])->name('admin.flags.update');
Route::delete('/admin/flags/{id}', [FeatureFlagController::class, 'destroy'])->name('admin.flags.destroy');
Route::post('/admin/flags/{id}/toggle', [FeatureFlagController::class, 'toggle'])->name('admin.flags.toggle');