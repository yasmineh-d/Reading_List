<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
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
            $request->input('category')
        );
        $categories = $this->categoryService->getAll();

        if ($request->ajax()) {
            return view('admin.books._table_body', compact('books'))->render();
        }

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function store(Request $request)
    {
        Log::info('BookController: store method called', $request->except('image'));

        try {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'publication_date' => 'nullable|date',
                'ISBN' => 'nullable|string|max:20',
                'image' => 'nullable|image|max:2048',
                'description' => 'nullable|string',
                'categories' => 'nullable|array',
                'categories.*' => 'exists:categories,id',
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('books', 'public');
                $data['image'] = '/storage/' . $path;
            }

            $data['user_id'] = auth()->id() ?? 1;
            Log::info('BookController: creating book with data', $data);

            $this->bookService->create($data);

            Log::info('BookController: book created successfully');

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => __('book.views.success') ?? 'Book created successfully!',
                ]);
            }

            return redirect()->route('admin.books.index')->with('success', __('book.views.success') ?? 'Book created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('BookController: Validation Error', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('BookController: Error creating book', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            throw $e;
        }
    }

    public function show($id)
    {
        $book = $this->bookService->getById($id);

        if (request()->ajax()) {
            // Make sure categories are loaded
            $book->load('categories');
            
            return response()->json([
                'success' => true,
                'book' => $book
            ]);
        }

        return view('admin.books.show', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publication_date' => 'nullable|date',
            'ISBN' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'remove_image' => 'nullable|boolean',
        ]);

        $book = $this->bookService->getById($id);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('books', 'public');
            $data['image'] = '/storage/' . $path;
        } elseif ($request->boolean('remove_image')) {
            $data['image'] = null;
        } else {
            // Keep existing image if no new one and not removing
            unset($data['image']);
        }

        $this->bookService->update($id, $data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Book updated successfully!',
            ]);
        }

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy($id)
    {
        $this->bookService->delete($id);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('book.views.deleted_success') ?? 'Book deleted successfully!',
                'redirect' => route('admin.books.index')
            ]);
        }

        return redirect()->route('admin.books.index')->with('success', __('book.views.deleted_success') ?? 'Book deleted successfully!');
    }
}
