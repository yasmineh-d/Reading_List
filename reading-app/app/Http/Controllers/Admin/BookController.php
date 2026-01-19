<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
     * Display a listing of books
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');
        $category = $request->get('category');

        $books = $this->bookService->getAll($search, $category);
        $categories = $this->categoryService->getAll();

        return view('admin.books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new book
     */
    public function create(): View
    {
        $categories = $this->categoryService->getAll();

        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created book
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publication_date' => 'nullable|date',
            'ISBN' => 'nullable|string|max:20',
            'image' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $validated['user_id'] = auth()->id();

        $this->bookService->create($validated);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified book
     */
    public function show(int $id): View
    {
        $book = $this->bookService->getById($id);

        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book
     */
    public function edit(int $id): View
    {
        $book = $this->bookService->getById($id);
        $categories = $this->categoryService->getAll();

        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publication_date' => 'nullable|date',
            'ISBN' => 'nullable|string|max:20',
            'image' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $this->bookService->update($id, $validated);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified book
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->bookService->delete($id);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Book deleted successfully.');
    }
}
