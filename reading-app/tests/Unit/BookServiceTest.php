<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\BookService;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Pagination\LengthAwarePaginator;

class BookServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected BookService $bookService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->bookService = new BookService();
    }

    /**
     * Test getting all books paginated.
     */
    public function test_it_can_get_all_books_paginated(): void
    {
        $books = $this->bookService->getAll();

        $this->assertInstanceOf(LengthAwarePaginator::class, $books);
        $this->assertNotEmpty($books->items());
    }

    /**
     * Test getting a book by ID.
     */
    public function test_it_can_get_book_by_id(): void
    {
        $firstBook = Book::first();
        $book = $this->bookService->getById($firstBook->id);

        $this->assertEquals($firstBook->id, $book->id);
        $this->assertEquals($firstBook->title, $book->title);
    }

    /**
     * Test creating a book.
     */
    public function test_it_can_create_a_book(): void
    {
        $user = User::first();
        $category = Category::first();

        $data = [
            'title' => 'New Test Book',
            'author' => 'Test Author',
            'publication_date' => '2023-01-01',
            'ISBN' => '1234567890',
            'description' => 'A test description',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ];

        $book = $this->bookService->create($data);

        $this->assertDatabaseHas('books', ['title' => 'New Test Book']);
        $this->assertInstanceOf(Book::class, $book);
        $this->assertEquals('New Test Book', $book->title);
    }

    /**
     * Test updating a book.
     */
    public function test_it_can_update_a_book(): void
    {
        $firstBook = Book::first();
        $updateData = ['title' => 'Updated Title'];

        $updatedBook = $this->bookService->update($firstBook->id, $updateData);

        $this->assertEquals('Updated Title', $updatedBook->title);
        $this->assertDatabaseHas('books', [
            'id' => $firstBook->id,
            'title' => 'Updated Title'
        ]);
    }

    /**
     * Test deleting a book.
     */
    public function test_it_can_delete_a_book(): void
    {
        $firstBook = Book::first();

        $this->bookService->delete($firstBook->id);

        $this->assertDatabaseMissing('books', ['id' => $firstBook->id]);
    }
}
