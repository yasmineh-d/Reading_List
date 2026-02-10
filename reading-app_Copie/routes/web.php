<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublicBookController;
use App\Http\Controllers\PublicCategoryController;
use App\Http\Controllers\AdminCategoryController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public Books & Categories
Route::prefix('books')->name('books.')->group(function () {
    Route::get('/', [PublicBookController::class, 'index'])->name('index');
    Route::get('/{id}', [PublicBookController::class, 'show'])->name('show');
});

Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [PublicCategoryController::class, 'index'])->name('index');
    Route::get('/{id}', [PublicCategoryController::class, 'show'])->name('show');
});

// Admin Routes (No authentication required)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('books', BookController::class);
});