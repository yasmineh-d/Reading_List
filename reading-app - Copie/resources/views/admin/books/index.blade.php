@extends('layouts.admin')

@section('content')
    <style>
        /* Pagination Styling to match ECO Shop */
        #pagination-container nav div:last-child span.relative,
        #pagination-container nav div:last-child a.relative {
            border-radius: 6px !important;
            margin-left: 4px !important;
            border: 1px solid #e5e7eb !important;
            background-color: #ffffff !important;
            color: #374151 !important;
            padding: 6px 12px !important;
            font-size: 0.8125rem !important;
            font-weight: 500 !important;
            transition: all 0.2s;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        #pagination-container nav div:last-child span.relative[aria-current="page"] {
            background-color: #1f2937 !important;
            color: white !important;
            border-color: #1f2937 !important;
        }

        #pagination-container nav div:last-child a.relative:hover {
            background-color: #f9fafb !important;
            border-color: #d1d5db !important;
        }
        
        .dark #pagination-container nav div:last-child span.relative,
        .dark #pagination-container nav div:last-child a.relative {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #94a3b8 !important;
        }
        
        .dark #pagination-container nav div:last-child span.relative[aria-current="page"] {
            background-color: #3b82f6 !important;
            color: white !important;
        }
    </style>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestion des Livres</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Gérez votre inventaire : ajoutez, modifiez ou supprimez vos articles.</p>
            </div>
            <div>
                <button type="button" onclick="openAddModal()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900 transition-all shadow-sm hover:shadow-md"
                    data-hs-overlay="#hs-add-book-modal">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Ajouter un produit
                </button>
            </div>
        </div>


        <!-- Search & Filter Card -->
        <div class="flex items-center justify-end gap-3 mb-4">
            <div class="relative w-80">
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    placeholder="Rechercher un produit..."
                    class="w-full py-2 pl-10 pr-4 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-700 dark:text-gray-400">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>
            </div>
            <select name="category" id="category-filter"
                class="py-2 px-3 text-sm bg-white border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-700 dark:text-gray-400">
                <option value="">Sélectionner...</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Books Table Card -->
        <div
            class="overflow-hidden bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-slate-900 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-slate-800">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            IMAGE</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            TITLE</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            AUTHOR</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            ISBN</th>
                        
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            CATEGORIES</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            DESCRIPTION</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">
                            ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="books-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @include('admin.books._table_body')
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div id="pagination-container" class="mt-6 px-2">
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
            
            // X Button Logic for Image Removal
            const removeImageBtn = document.getElementById('remove-image-btn');
            if (removeImageBtn) {
                removeImageBtn.addEventListener('click', function() {
                    // Hide preview
                    document.getElementById('current-image-preview').classList.add('hidden');
                    // Set hidden input to 1
                    const removeInput = document.getElementById('remove_image_input');
                    if (removeInput) removeInput.value = '1';
                    // Clear file input so no file is uploaded if they just want to delete
                    document.getElementById('image').value = ''; 
                });
            }

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
            
            // Remove method field if it exists
            const methodField = document.getElementById('method-field');
            if (methodField) {
                methodField.remove();
            }
            
            // Uncheck all category checkboxes
            document.querySelectorAll('input[name="categories[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });

            // Hide image preview for new books
            document.getElementById('current-image-preview').classList.add('hidden');
            const removeInput = document.getElementById('remove_image_input');
            if (removeInput) removeInput.value = '0';
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
                    document.getElementById('ISBN').value = data.book.ISBN || '';
                    document.getElementById('description').value = data.book.description || '';

                    // Check categories
                    document.querySelectorAll('input[name="categories[]"]').forEach(checkbox => {
                        checkbox.checked = data.book.categories.some(cat => cat.id == checkbox.value);
                    });

                    // Handle Image Preview
                    const previewContainer = document.getElementById('current-image-preview');
                    const previewImg = document.getElementById('edit-image-preview');
                    const removeInput = document.getElementById('remove_image_input');
                    
                    if (removeInput) removeInput.value = '0';

                    if (data.book.image) {
                        previewContainer.classList.remove('hidden');
                        // Use same logic as table for image path
                        const isExternal = data.book.image.startsWith('http') || data.book.image.startsWith('/');
                        previewImg.src = isExternal ? data.book.image : `/storage/${data.book.image}`;
                    } else {
                        previewContainer.classList.add('hidden');
                    }

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
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.HSOverlay.close(document.getElementById('hs-add-book-modal'));
                        showAlert(data.message, 'success');
                        
                        // Wait 1.5 seconds before reloading to show the success message
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    let message = 'An error occurred';
                    if (error.errors) {
                        message = Object.values(error.errors).flat().join('\n');
                    } else if (error.message) {
                        message = error.message;
                    }
                    showAlert(message, 'error');
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