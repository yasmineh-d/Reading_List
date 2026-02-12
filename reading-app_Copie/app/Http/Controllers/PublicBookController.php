<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class PublicBookController extends Controller
{
    protected BookService $bookService;
    protected CategoryService $categoryService;

    public function __construct(BookService $bookService, CategoryService $categoryService)
    {
        $this->bookService = $bookService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $books = $this->bookService->getAll(
            $request->input('search'),
            $request->input('category'),
            'desc',
            3
        );
        $categories = $this->categoryService->getAll();

        if ($request->ajax()) {
            return view('public.books._list', compact('books'))->render();
        }

        return view('public.books.index', compact('books', 'categories'));
    }

    public function show($id)
    {
        $book = $this->bookService->getById($id);

        // Ensure relationships are loaded if not already handled by service
        $book->load(['categories', 'user']);

        return view('public.books.show', compact('book'));
    }
}
