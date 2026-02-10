<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\BookService;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected BookService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BookService();
    }

    public function test_it_can_get_all_books()
    {
        $result = $this->service->getAll();
        $this->assertGreaterThan(0, $result->total());
    }

    public function test_it_can_filter_books_by_search()
    {
        $result = $this->service->getAll('Laravel');

        $this->assertGreaterThan(0, $result->total());

        $firstBook = collect($result->items())->first();
        $this->assertStringContainsString('Laravel', $firstBook->title);
    }

    public function test_it_can_filter_books_by_category()
    {
        // Pick a category that exists in your seeded data
        $category = Category::where('name', 'Informatique')->first();

        $result = $this->service->getAll(null, $category->id);

        $this->assertGreaterThan(0, $result->total());

        // Ensure every returned book belongs to the selected category
        foreach ($result->items() as $book) {
            $bookCategories = $book->categories->pluck('id')->toArray();
            $this->assertContains($category->id, $bookCategories);
        }
    }

    public function test_it_can_get_book_by_id()
    {
        $firstBook = Book::first();
        $book = $this->service->getById($firstBook->id);

        $this->assertEquals($firstBook->id, $book->id);
        $this->assertEquals($firstBook->title, $book->title);
    }

    public function test_it_can_create_a_book_with_categories()
    {
        $categories = Category::take(2)->get();
        $user = User::first();

        $data = [
            'title' => 'New Test Book',
            'author' => 'Test Author',
            'publication_date' => '2023-01-01',
            'ISBN' => '9781234567899',
            'description' => 'A test description',
            'user_id' => $user->id,
            'categories' => $categories->pluck('id')->toArray(),
        ];

        $book = $this->service->create($data);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'New Test Book',
        ]);

        $this->assertCount(2, $book->categories);
    }

    public function test_it_can_update_a_book()
    {
        $book = Book::first();

        $updatedData = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
        ];

        $this->service->update($book->id, $updatedData);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Updated Title',
            'author' => 'Updated Author',
        ]);
    }

    public function test_it_can_delete_a_book()
    {
        $book = Book::first();

        $this->service->delete($book->id);

        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);
    }
}
