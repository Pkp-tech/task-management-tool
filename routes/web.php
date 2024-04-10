<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\v1\TaskController;
use App\Http\Controllers\v1\TaskGroupController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Route::get('/clear-session', function () {
//     // Flush the session data
//     Session::flush();

//     // Redirect to a login page or any other page as needed
//     return redirect('/login');
// });

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [TaskController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/task-group', [TaskGroupController::class, 'edit'])->name('task-group');
    Route::post('/task-group', [TaskGroupController::class, 'add'])->name('task-group.add');
    Route::patch('/task-group/{id}', [TaskGroupController::class, 'update'])->name('task-group.update');
    Route::delete('/task-group/{id}', [TaskGroupController::class, 'destroy'])->name('task-group.destroy');


});

require __DIR__.'/auth.php';
