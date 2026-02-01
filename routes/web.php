<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\FeatureFlagController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/debug', [HomeController::class, 'debug'])->name('debug');

// Admin authentication routes
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin dashboard route
Route::get('/admin/dashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard');

// Admin feature flag routes
Route::get('/admin/features', [FeatureFlagController::class, 'index'])->name('admin.features.index');
Route::get('/admin/features/create', [FeatureFlagController::class, 'create'])->name('admin.features.create');
Route::post('/admin/features', [FeatureFlagController::class, 'store'])->name('admin.features.store');
Route::get('/admin/features/{id}/edit', [FeatureFlagController::class, 'edit'])->name('admin.features.edit');
Route::put('/admin/features/{id}', [FeatureFlagController::class, 'update'])->name('admin.features.update');
Route::delete('/admin/features/{id}', [FeatureFlagController::class, 'destroy'])->name('admin.features.destroy');
Route::post('/admin/features/{id}/toggle', [FeatureFlagController::class, 'toggle'])->name('admin.features.toggle');