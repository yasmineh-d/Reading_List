@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold font-heading text-gray-800 dark:text-white">Books</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Manage your book collection</p>
            </div>
            <div>
                <button type="button" onclick="openAddModal()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900 transition-all shadow-md hover:shadow-lg"
                    data-hs-overlay="#hs-add-book-modal">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Add New Book
                </button>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <div id="alert-container"></div>

        <!-- Search & Filter Card -->
        <div class="p-4 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-slate-900 dark:border-gray-700">
            <div class="grid gap-4 md:grid-cols-3">
                <div class="md:col-span-2 relative">
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Search by title or author..."
                        class="w-full py-2 pl-10 pr-4 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-700 dark:text-gray-400">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                    </div>
                </div>
                <div>
                    <select name="category" id="category-filter"
                        class="w-full py-2 px-3 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-700 dark:text-gray-400">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Books Table Card -->
        <div
            class="overflow-hidden bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-slate-900 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-slate-800">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            Book</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            Author</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            Categories</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">
                            Actions</th>
                    </tr>
                </thead>
                <tbody id="books-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @include('admin.books._table_body')
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="pagination-container" class="mt-4">
            {{ $books->withQueryString()->links() }}
        </div>

        <!-- Modals -->
        @include('admin.books._modal')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            const categoryFilter = document.getElementById('category-filter');
            const tableBody = document.getElementById('books-table-body');
            const paginationContainer = document.getElementById('pagination-container');

            function fetchBooks() {
                const search = searchInput.value;
                const category = categoryFilter.value;

                const url = new URL(window.location.href);
                url.searchParams.set('search', search);
                url.searchParams.set('category', category);
                url.searchParams.set('page', 1);

                window.history.pushState({}, '', url);

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        tableBody.innerHTML = html;
                        if (window.lucide) window.lucide.createIcons();
                    });
            }

            function debounce(func, delay = 300) {
                let timer;
                return (...args) => {
                    clearTimeout(timer);
                    timer = setTimeout(() => func.apply(this, args), delay);
                };
            }

            searchInput.addEventListener('input', debounce(fetchBooks));
            categoryFilter.addEventListener('change', fetchBooks);

            // Handle pagination
            document.addEventListener('click', function (e) {
                if (e.target.closest('.pagination a')) {
                    e.preventDefault();
                    const url = e.target.closest('.pagination a').href;

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.text())
                        .then(html => {
                            tableBody.innerHTML = html;
                            if (window.lucide) window.lucide.createIcons();
                        });
                }
            });
        });

        function openAddModal() {
            document.getElementById('modal-title').textContent = 'Add New Book';
            document.getElementById('bookForm').reset();
            document.getElementById('bookForm').action = '{{ route('admin.books.store') }}';
            document.getElementById('method-field').remove();
        }

        function openEditModal(bookId) {
            fetch(`/admin/books/${bookId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modal-title').textContent = 'Edit Book';
                    document.getElementById('bookForm').action = `/admin/books/${bookId}`;

                    // Add method field if not exists
                    if (!document.getElementById('method-field')) {
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'PUT';
                        methodField.id = 'method-field';
                        document.getElementById('bookForm').appendChild(methodField);
                    }

                    // Populate form
                    document.getElementById('title').value = data.book.title;
                    document.getElementById('author').value = data.book.author;

                    // Check categories
                    document.querySelectorAll('input[name="categories[]"]').forEach(checkbox => {
                        checkbox.checked = data.book.categories.some(cat => cat.id == checkbox.value);
                    });

                    // Open modal
                    window.HSOverlay.open(document.getElementById('hs-add-book-modal'));
                });
        }

        // Handle form submission via AJAX
        document.getElementById('bookForm')?.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.HSOverlay.close(document.getElementById('hs-add-book-modal'));
                        showAlert(data.message, 'success');
                        // Reload table
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('An error occurred', 'error');
                });
        });

        function showAlert(message, type) {
            const alertContainer = document.getElementById('alert-container');
            const alertClass = type === 'success' ? 'bg-green-50 text-green-800 border-green-200' : 'bg-red-50 text-red-800 border-red-200';
            alertContainer.innerHTML = `
                    <div class="p-4 border rounded-lg ${alertClass}">
                        ${message}
                    </div>
                `;
            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 3000);
        }

        function deleteBook(bookId) {
            if (!confirm('Are you sure you want to delete this book?')) return;

            fetch(`/admin/books/${bookId}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

@endsection