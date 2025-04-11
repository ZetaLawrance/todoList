<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\StickyNoteController;

Route::get('/', function () {
    return redirect()->route('todos.index');
});

Route::resource('todos', TodoController::class);
Route::patch('todos/{todo}/toggle-complete', [TodoController::class, 'toggleComplete'])->name('todos.toggle');

Route::resource('sticky-notes', StickyNoteController::class);
