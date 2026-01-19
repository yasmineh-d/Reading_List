<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\BookService;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;
    protected BookService $bookService;

    public function __construct(CategoryService $categoryService, BookService $bookService)
    {
        $this->categoryService = $categoryService;
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of categories for public view
     */
    public function index(): View
    {
        $categories = $this->categoryService->getAll();

        return view('public.categories.index', compact('categories'));
    }

    /**
     * Display the specified category with its books
     */
    public function show(int $id): View
    {
        $category = $this->categoryService->getById($id);
        $books = $this->bookService->getAll(null, $id);

        return view('public.categories.show', compact('category', 'books'));
    }
}
