<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\Settings\AppearanceController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('page-settings', [SettingsController::class, 'edit'])->name('page-settings.index');
    Route::post('page-settings', [SettingsController::class, 'update'])->name('page-settings.update');
    Route::resource('posts', PostController::class);
    Route::get('settings/appearance', [AppearanceController::class, 'edit'])->name('settings.appearance.edit');
    Route::put('settings/appearance', [AppearanceController::class, 'update'])->name('settings.appearance.update');
    Route::get('settings/password', [PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::resource('users', UsersController::class);
});

require __DIR__.'/auth.php';
