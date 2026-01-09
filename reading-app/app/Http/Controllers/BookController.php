<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Models\Category;

class BookController extends Controller
{
    protected BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index()
    {
        $search = request('search');
        $category = request('category');
        $data = $this->bookService->getAll($search, $category);
        $categories = Category::all();

        if (request()->ajax()) {
            return view('books.partials.results', compact('data'))->render();
        }

        return view('books.index', compact('data', 'categories'));
    }

    public function store()
    {
        $data = request()->validate([
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'ISBN' => 'required|unique:books,ISBN',
            'publication_date' => 'required|date',
            'categories' => 'required|array',
            'category_id' => 'nullable', // Keeping it for compatibility if table still has it
            'user_id' => 'required',
        ]);

        $this->bookService->create($data);
        return redirect()->back()->with('success', 'Livre ajouté avec succès !');
    }

    public function update(int $id)
    {
        $data = request()->validate([
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'categories' => 'required|array',
        ]);

        $this->bookService->update($id, $data);
        return redirect()->back()->with('success', 'Livre mis à jour avec succès !');
    }

    public function destroy(int $id)
    {
        $this->bookService->delete($id);
        return redirect()->back()->with('success', 'Livre supprimé avec succès !');
    }
}
