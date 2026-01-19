<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;

class BookService
{
    public function getAll(?string $search = null, ?int $category = null): LengthAwarePaginator
    {
        $query = Book::with(['categories', 'user']);

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($category) {
            $query->whereHas('categories', function ($q) use ($category) {
                $q->where('categories.id', $category);
            });
        }

        return $query->paginate(10);
    }

    public function getById(int $id): Book
    {
        return Book::findOrFail($id);
    }

    public function create(array $data): Book
    {
        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        $book = Book::create($data);

        if (!empty($categories)) {
            $book->categories()->sync($categories);
        }

        return $book;
    }

    public function update(int $id, array $data): Book
    {
        $book = Book::findOrFail($id);

        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        $book->update($data);

        $book->categories()->sync($categories);

        return $book;
    }

    public function delete(int $id): bool|null
    {
        return Book::destroy($id);
    }
}
