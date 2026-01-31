<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\FeatureFlagController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::get('/admin/dashboard', [FeatureFlagController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/features', [FeatureFlagController::class, 'index'])->name('admin.features.index');
Route::get('/admin/features/create', [FeatureFlagController::class, 'create'])->name('admin.features.create');
Route::post('/admin/features', [FeatureFlagController::class, 'store'])->name('admin.features.store');
Route::get('/admin/features/{id}/edit', [FeatureFlagController::class, 'edit'])->name('admin.features.edit');
Route::put('/admin/features/{id}', [FeatureFlagController::class, 'update'])->name('admin.features.update');
Route::delete('/admin/features/{id}', [FeatureFlagController::class, 'destroy'])->name('admin.features.destroy');
Route::post('/admin/features/{id}/toggle', [FeatureFlagController::class, 'toggle'])->name('admin.features.toggle');