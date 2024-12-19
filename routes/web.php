<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tasks', TaskController::class);

Route::post('tasks/completed/{task}', [TaskController::class, 'completed'])->name('tasks.completed');