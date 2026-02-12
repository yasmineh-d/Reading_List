@extends('layouts.public')

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
        <!-- Alert Container -->
        <div id="alert-container" class="fixed top-4 right-4 z-[9999] w-80"></div>

        <!-- Header -->
        <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestion des Livres</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Gérez votre inventaire : ajoutez, modifiez ou supprimez
                    vos articles.</p>
            </div>
            <div>
                <button type="button" onclick="openAddModal()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900 transition-all shadow-sm hover:shadow-md">
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
        (function () {
            // Helper: Show standard toast/alert
            window.showAlert = function (message, type = 'success') {
                const container = document.getElementById('alert-container');
                if (!container) return;

                const bgColor = type === 'success' ? 'bg-green-600' : 'bg-red-600';
                container.innerHTML = `
                            <div class="p-4 ${bgColor} text-white rounded-lg shadow-xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'}"></path></svg>
                                <span>${message}</span>
                            </div>
                        `;

                if (type === 'success') {
                    setTimeout(() => { container.innerHTML = ''; }, 5000);
                }
            };

            // Global Error Handling
            window.onerror = function (msg, url, line) {
                console.error('JS Error:', msg, 'at', url, ':', line);
                return false;
            };

            // Manual Modal Open
            window.openAddModal = function () {
                const form = document.getElementById('bookForm');
                if (!form) return;

                form.reset();
                form.action = "{{ route('admin.books.store') }}";
                const methodField = document.getElementById('method-field');
                if (methodField) methodField.remove();

                document.getElementById('modal-title').textContent = 'Add New Book';
                document.querySelectorAll('input[name="categories[]"]').forEach(cb => cb.checked = false);
                document.getElementById('current-image-preview')?.classList.add('hidden');

                const modal = document.getElementById('hs-add-book-modal');
                modal.classList.remove('hidden', 'pointer-events-none');
                modal.classList.add('flex', 'pointer-events-auto');

                if (window.HSOverlay) {
                    window.HSOverlay.open(modal);
                }
            };

            // Manual Modal Close
            window.closeBookModal = function () {
                if (window.HSOverlay && typeof window.HSOverlay.close === 'function') {
                    window.HSOverlay.close(document.getElementById('hs-add-book-modal'));
                } else {
                    const modal = document.getElementById('hs-add-book-modal');
                    modal.classList.add('hidden', 'pointer-events-none');
                    modal.classList.remove('flex', 'pointer-events-auto');
                }
            }

            // Manual Save Function
            window.saveBook = function () {
                const saveBtn = document.getElementById('save-book-btn');
                const form = document.getElementById('bookForm');

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const originalText = saveBtn.innerHTML;
                saveBtn.disabled = true;
                saveBtn.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin h-4 w-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...</span>';

                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(async r => {
                        const contentType = r.headers.get('content-type');
                        if (contentType && contentType.includes('application/json')) {
                            const data = await r.json();
                            if (!r.ok) throw new Error(data.message || `Error ${r.status}`);
                            return data;
                        } else {
                            throw new Error('Server returned non-JSON response.');
                        }
                    })
                    .then(data => {
                        showAlert(data.message || 'Book saved!');
                        window.closeBookModal();
                        setTimeout(() => location.reload(), 1000);
                    })
                    .catch(err => {
                        console.error('Save error:', err);
                        showAlert(err.message, 'error');
                        saveBtn.disabled = false;
                        saveBtn.innerHTML = originalText;
                    });
            };

            // Manual Edit Modal Open
            window.openEditModal = function (id) {
                const form = document.getElementById('bookForm');
                if (!form) return;

                // Reset form
                form.reset();
                document.querySelectorAll('input[name="categories[]"]').forEach(cb => cb.checked = false);
                document.getElementById('current-image-preview')?.classList.add('hidden');

                // Set Action
                form.action = `/admin/books/${id}`;

                // Add hidden PUT method
                let methodField = document.getElementById('method-field');
                if (!methodField) {
                    methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.id = 'method-field';
                    methodField.value = 'PUT';
                    form.appendChild(methodField);
                }

                // Fetch Data
                fetch(`/admin/books/${id}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success && data.book) {
                            const book = data.book;

                            document.getElementById('title').value = book.title;
                            document.getElementById('author').value = book.author;
                            document.getElementById('ISBN').value = book.ISBN || '';
                            document.getElementById('description').value = book.description || '';

                            // Handle Image
                            const imgPreview = document.getElementById('edit-image-preview');
                            const imgContainer = document.getElementById('current-image-preview');
                            if (book.image && imgPreview && imgContainer) {
                                imgPreview.src = book.image; // Assuming processed URL or relative path
                                imgContainer.classList.remove('hidden');
                            }

                            // Handle Categories
                            if (book.categories && Array.isArray(book.categories)) {
                                book.categories.forEach(cat => {
                                    const checkbox = document.querySelector(`input[name="categories[]"][value="${cat.id}"]`);
                                    if (checkbox) checkbox.checked = true;
                                });
                            }

                            document.getElementById('modal-title').textContent = 'Edit Book';

                            const modal = document.getElementById('hs-add-book-modal');
                            modal.classList.remove('hidden', 'pointer-events-none');
                            modal.classList.add('flex', 'pointer-events-auto');

                            if (window.HSOverlay) {
                                window.HSOverlay.open(modal);
                            }
                        }
                    })
                    .catch(err => console.error('Error loading book:', err));
            };

            // Explicit Event Listeners
            document.addEventListener('DOMContentLoaded', () => {
                const saveBtn = document.getElementById('save-book-btn');
                if (saveBtn) {
                    saveBtn.addEventListener('click', () => window.saveBook());
                }

                // Search/Filter AJAX
                const searchInput = document.getElementById('search');
                const categoryFilter = document.getElementById('category-filter');
                const tableBody = document.getElementById('books-table-body');

                function updateTable() {
                    const url = new URL(location.href);
                    url.searchParams.set('search', searchInput?.value || '');
                    url.searchParams.set('category', categoryFilter?.value || '');
                    url.searchParams.set('page', 1);

                    history.pushState({}, '', url);

                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(r => r.text())
                        .then(html => {
                            if (tableBody) tableBody.innerHTML = html;
                            if (window.lucide) window.lucide.createIcons();
                        });
                }

                searchInput?.addEventListener('input', () => {
                    clearTimeout(window.searchTimer);
                    window.searchTimer = setTimeout(updateTable, 300);
                });
                categoryFilter?.addEventListener('change', updateTable);
            });
        })();
    </script>

@endsection