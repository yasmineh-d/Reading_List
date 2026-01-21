<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function getAll(): Collection
    {
        return Category::all();
    }

    public function getById(int $id): Category
    {
        return Category::with('books')->findOrFail($id);
    }
}