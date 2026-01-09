<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

Route::get('/books', [BookController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);

Route::resource('users', UserController::class);
Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');


Route::get('/', function () {
    return view('welcome');
});
