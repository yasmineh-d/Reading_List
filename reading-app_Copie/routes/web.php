<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublicBookController;
use App\Http\Controllers\PublicCategoryController;
use App\Http\Controllers\AdminCategoryController;

use App\Http\Controllers\AuthController;

// Public Routes
Route::get('/', function () {
    return redirect()->route('books.index');
})->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Books & Categories
Route::prefix('books')->name('books.')->group(function () {
    Route::get('/', [PublicBookController::class, 'index'])->name('index');
    Route::get('/{id}', [PublicBookController::class, 'show'])->name('show');
});

Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [PublicCategoryController::class, 'index'])->name('index');
    Route::get('/{id}', [PublicCategoryController::class, 'show'])->name('show');
});

// Admin Routes (Protected by Auth Middleware - manually applied in controller or here if desired)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('books', BookController::class);
});