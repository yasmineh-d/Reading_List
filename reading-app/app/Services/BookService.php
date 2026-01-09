<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function getAll(?string $search = null, ?int $category = null)
    {
        $query = Book::with(['categories', 'user']);

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($category) {
            $query->where('category_id', $category);
        }

        return $query->paginate(10);
    }

    public function getById(int $id)
    {
        return Book::findOrFail($id);
    }

    public function create(array $data)
    {
        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        $book = Book::create($data);

        if (!empty($categories)) {
            $book->categories()->sync($categories);
        }

        return $book;
    }

    public function update(int $id, array $data)
    {
        $book = Book::findOrFail($id);

        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        $book->update($data);

        $book->categories()->sync($categories);

        return $book;
    }

    public function delete(int $id)
    {
        return Book::destroy($id);
    }
}
