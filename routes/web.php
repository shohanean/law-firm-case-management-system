<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\projecttypeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Redirect to dashboard if authenticated, otherwise to login
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::resource('projecttype', ProjectTypeController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
