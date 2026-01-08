<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function getAll()
    {
        return Book::with(['category', 'user'])->paginate(10);
    }

    public function getById(int $id)
    {
        return Book::findOrFail($id);
    }

    public function create(array $data)
    {
        return Book::create($data);
    }

    public function update(int $id, array $data)
    {
        $book = Book::findOrFail($id);
        $book->update($data);
        return $book;
    }

    public function delete(int $id)
    {
        return Book::destroy($id);
    }
}
