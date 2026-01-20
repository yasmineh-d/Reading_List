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

// Public Books & Categories
// Route::prefix('books')->name('books.')->group(function () {
//     Route::get('/', [PublicBookController::class, 'index'])->name('index');
//     Route::get('/{id}', [PublicBookController::class, 'show'])->name('show');
// });

// Route::prefix('categories')->name('categories.')->group(function () {
//     Route::get('/', [PublicCategoryController::class, 'index'])->name('index');
//     Route::get('/{id}', [PublicCategoryController::class, 'show'])->name('show');
// });

// // Admin Routes (protected by auth middleware)
// Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {



//     // Admin Categories Management
//     Route::resource('categories', AdminCategoryController::class);
