<?php

use App\Http\Controllers\CaseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Redirect to dashboard if authenticated, otherwise to login
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/your-assignments', [HomeController::class, 'yourAssignments'])->name('your.assignments');
    Route::resource('projecttype', ProjectTypeController::class);
    Route::resource('case-status', StatusController::class)->names('status');
    Route::resource('user', UserController::class)->except(['show', 'create']);
    Route::patch('/user/{id}/restore', [UserController::class, 'restore'])->name('user.restore');
    Route::resource('case', CaseController::class);
    Route::post('/case/{case}/remark', [CaseController::class, 'remarkStore'])->name('case.remark.store');
    Route::post('/import/preview', [ImportController::class, 'preview'])->name('import.preview');
    Route::post('/import/confirm', [ImportController::class, 'confirm'])->name('import.confirm');
    Route::patch('/case/{case}/status', [CaseController::class, 'updateStatus'])->name('case.status.update');
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/my-tasks', [TaskController::class, 'myTasks'])->name('tasks.my');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
