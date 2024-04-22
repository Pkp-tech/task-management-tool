<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\v1\LabelController;
use App\Http\Controllers\v1\StatusColumnController;
use App\Http\Controllers\v1\TaskController;
use App\Http\Controllers\v1\TaskGroupController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

require __DIR__ . '/auth.php';

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
    Route::post('/add-tasks', [TaskGroupController::class, 'addTasks'])->name('add-tasks');

    Route::post('/add-status-column', [StatusColumnController::class, 'add'])->name('status-column.add');
    Route::patch('/update-status-column', [StatusColumnController::class, 'update'])->name('status-column.update');
    Route::delete('/status-column', [StatusColumnController::class, 'destroy'])->name('status-column.destroy');

    Route::post('/add-task', [TaskController::class, 'add'])->name('task.add');
    Route::patch('/task', [TaskController::class, 'update'])->name('task.update');
    Route::delete('/task', [TaskController::class, 'destroy'])->name('task.destroy');
    Route::get('/get-task/{id}', [TaskController::class, 'getTaskData'])->name('task.get');
    Route::put('/tasks/{taskId}/update-status', [TaskController::class, 'updateStatus'])->name('task.updateStatus');
    Route::delete('/remove-file', [TaskController::class, 'removeFile'])->name('remove-file');

    Route::post('/add-label', [LabelController::class, 'createLabel'])->name('label.add');
    Route::delete('/remove-label', [LabelController::class, 'destroy'])->name('label.destroy');
});

Route::post('/update-task-group-session', [TaskGroupController::class, 'updateTaskGroupSession']);
