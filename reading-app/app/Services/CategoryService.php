<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function getAll(): Collection
    {
        return Category::withCount('books')
            ->orderBy('name')
            ->get();
    }

    public function getById(int $id): Category
    {
        return Category::with(['books' => function ($query) {
            $query->select('id', 'title', 'author', 'image');
        }])->findOrFail($id);
    }

    public function getAllPaginated(int $perPage = 12): LengthAwarePaginator
    {
        return Category::withCount('books')
            ->orderBy('name')
            ->paginate($perPage);
    }
}