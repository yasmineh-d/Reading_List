<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Public\BookController as PublicBookController;
use App\Http\Controllers\Public\CategoryController as PublicCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

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

// Admin Routes (protected by auth middleware)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Books Management
    Route::resource('books', AdminBookController::class);

    // Admin Categories Management
    Route::resource('categories', AdminCategoryController::class);
});
