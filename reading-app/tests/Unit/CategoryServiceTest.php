<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CategoryService;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CategoryService $categoryService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryService = new CategoryService();
    }

    /**
     * Test getting all categories.
     */
    public function test_it_can_get_all_categories(): void
    {
        // Seed some categories
        Category::factory()->count(3)->create();

        $categories = $this->categoryService->getAll();

        $this->assertInstanceOf(Collection::class, $categories);
        $this->assertCount(3, $categories);
    }
}
