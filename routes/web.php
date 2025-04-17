<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return redirect()->route('todos.index');
});

Route::resource('todos', TodoController::class);
Route::patch('todos/{todo}/toggle-complete', [TodoController::class, 'toggleComplete'])->name('todos.toggle');