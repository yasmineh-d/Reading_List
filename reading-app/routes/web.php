<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Books Management
Route::name('admin.')->group(function () {
    Route::resource('books', BookController::class);
});