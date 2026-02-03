<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class PublicCategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAll();
        return view('public.categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = $this->categoryService->getById($id);
        return view('public.categories.show', compact('category'));
    }
}
