<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\v1\TaskGroupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/task-group', [TaskGroupController::class, 'edit'])->name('task-group');
    Route::post('/task-group', [TaskGroupController::class, 'add'])->name('task-group.add');

});

require __DIR__.'/auth.php';
