<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicBookController;
use App\Http\Controllers\PublicCategoryController;

// Home redirect
Route::get('/', function () {
    return redirect()->route('books.index');
})->name('home');

// Public Books
Route::prefix('books')->name('books.')->group(function () {
    Route::get('/', [PublicBookController::class, 'index'])->name('index');
    Route::get('/{id}', [PublicBookController::class, 'show'])->name('show');
});

// Public Categories
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [PublicCategoryController::class, 'index'])->name('index');
    Route::get('/{id}', [PublicCategoryController::class, 'show'])->name('show');
});
