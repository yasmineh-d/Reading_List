<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    protected BookService $bookService;
    protected CategoryService $categoryService;

    public function __construct(BookService $bookService, CategoryService $categoryService)
    {
        $this->bookService = $bookService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of books for public view
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');
        $category = $request->get('category');

        $books = $this->bookService->getAll($search, $category);
        $categories = $this->categoryService->getAll();

        return view('public.books.index', compact('books', 'categories'));
    }

    /**
     * Display the specified book
     */
    public function show(int $id): View
    {
        $book = $this->bookService->getById($id);

        return view('public.books.show', compact('book'));
    }
}
