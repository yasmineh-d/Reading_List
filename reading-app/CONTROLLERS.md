# Controllers Documentation

## Overview
This application follows a clean architecture pattern where **Controllers** are responsible for handling HTTP requests and rendering views, while all **business logic** is delegated to **Services**.

## Architecture

```
Request → Controller → Service → Model → Database
Response ← Controller ← Service ← Model ←
```

### Controllers (View Layer)
- Handle HTTP requests and responses
- Validate incoming data
- Call appropriate service methods
- Return views with data
- Handle redirects and flash messages

### Services (Business Logic Layer)
- Contain all business logic
- Interact with models
- Handle data transformations
- Manage database transactions
- Return data to controllers

## Controller Structure

### Admin Controllers
Located in `app/Http/Controllers/Admin/`

#### BookController
Handles CRUD operations for books in the admin panel.

**Routes:** `admin.books.*`

| Method | Route | Action | Description |
|--------|-------|--------|-------------|
| GET | `/admin/books` | index | List all books with filters |
| GET | `/admin/books/create` | create | Show create form |
| POST | `/admin/books` | store | Store new book |
| GET | `/admin/books/{id}` | show | Show single book |
| GET | `/admin/books/{id}/edit` | edit | Show edit form |
| PUT/PATCH | `/admin/books/{id}` | update | Update book |
| DELETE | `/admin/books/{id}` | destroy | Delete book |

**Dependencies:**
- `BookService` - For book operations
- `CategoryService` - For category dropdown data

#### CategoryController
Handles CRUD operations for categories in the admin panel.

**Routes:** `admin.categories.*`

| Method | Route | Action | Description |
|--------|-------|--------|-------------|
| GET | `/admin/categories` | index | List all categories |
| GET | `/admin/categories/create` | create | Show create form |
| POST | `/admin/categories` | store | Store new category |
| GET | `/admin/categories/{id}` | show | Show single category |
| GET | `/admin/categories/{id}/edit` | edit | Show edit form |
| PUT/PATCH | `/admin/categories/{id}` | update | Update category |
| DELETE | `/admin/categories/{id}` | destroy | Delete category |

**Dependencies:**
- `CategoryService` - For category operations

### Public Controllers
Located in `app/Http/Controllers/Public/`

#### BookController
Handles read-only book viewing for public users.

**Routes:** `books.*`

| Method | Route | Action | Description |
|--------|-------|--------|-------------|
| GET | `/books` | index | List all books (with search/filter) |
| GET | `/books/{id}` | show | Show single book details |

**Dependencies:**
- `BookService` - For book data
- `CategoryService` - For filter options

#### CategoryController
Handles read-only category viewing for public users.

**Routes:** `categories.*`

| Method | Route | Action | Description |
|--------|-------|--------|-------------|
| GET | `/categories` | index | List all categories |
| GET | `/categories/{id}` | show | Show category with its books |

**Dependencies:**
- `CategoryService` - For category data
- `BookService` - For books in category

## Services

### BookService
Located in `app/Services/BookService.php`

**Methods:**
- `getAll(?string $search, ?int $category): LengthAwarePaginator` - Get paginated books with filters
- `getById(int $id): Book` - Get single book by ID
- `create(array $data): Book` - Create new book with categories
- `update(int $id, array $data): Book` - Update book and sync categories
- `delete(int $id): bool|null` - Delete book

### CategoryService
Located in `app/Services/CategoryService.php`

**Methods:**
- `getAll(): Collection` - Get all categories
- `getById(int $id): Category` - Get single category by ID
- `create(array $data): Category` - Create new category
- `update(int $id, array $data): Category` - Update category
- `delete(int $id): bool|null` - Delete category

## Example Usage

### In a Controller

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index(Request $request)
    {
        // Controller only handles request/response
        $books = $this->bookService->getAll(
            $request->get('search'),
            $request->get('category')
        );

        return view('admin.books.index', compact('books'));
    }

    public function store(Request $request)
    {
        // Validation in controller
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            // ... other rules
        ]);

        // Business logic in service
        $this->bookService->create($validated);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Book created successfully.');
    }
}
```

## Authentication & Authorization

Admin routes are protected by the `auth` middleware:

```php
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('books', AdminBookController::class);
    Route::resource('categories', AdminCategoryController::class);
});
```

Public routes are accessible to everyone:

```php
Route::get('/books', [PublicBookController::class, 'index'])->name('books.index');
```

## Next Steps

To complete the implementation, you'll need to create the following views:

### Admin Views
- `resources/views/admin/books/index.blade.php`
- `resources/views/admin/books/create.blade.php`
- `resources/views/admin/books/edit.blade.php`
- `resources/views/admin/books/show.blade.php`
- `resources/views/admin/categories/index.blade.php`
- `resources/views/admin/categories/create.blade.php`
- `resources/views/admin/categories/edit.blade.php`
- `resources/views/admin/categories/show.blade.php`

### Public Views
- `resources/views/public/books/index.blade.php`
- `resources/views/public/books/show.blade.php`
- `resources/views/public/categories/index.blade.php`
- `resources/views/public/categories/show.blade.php`

## Benefits of This Architecture

1. **Separation of Concerns**: Controllers handle HTTP, Services handle business logic
2. **Testability**: Services can be unit tested independently
3. **Reusability**: Services can be used by multiple controllers or commands
4. **Maintainability**: Changes to business logic don't affect controllers
5. **Single Responsibility**: Each layer has one clear purpose
