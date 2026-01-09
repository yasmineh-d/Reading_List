<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

Route::resource('books', BookController::class);
Route::get('/categories', [CategoryController::class, 'index']);

Route::resource('users', UserController::class);


Route::get('/', function () {
    return view('welcome');
});
