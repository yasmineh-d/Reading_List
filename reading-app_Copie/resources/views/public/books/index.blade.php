@extends('layouts.public')

@section('content')
    <div class="space-y-8">
        <!-- Header & Search -->
        <div class="text-center max-w-2xl mx-auto pt-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Library</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8">
                Explore our collection of {{ $books->total() }} books across various genres.
            </p>

            <!-- Search & Filter (Admin Replica) -->
            <div class="max-w-2xl mx-auto mb-8">
                <form id="filter-form" action="{{ route('books.index') }}" method="GET"
                    class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="relative flex-1 w-full">
                        <input type="text" name="search" id="public-search" value="{{ request('search') }}"
                            placeholder="Rechercher par titre..."
                            class="w-full py-2.5 pl-10 pr-4 text-sm bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-900 dark:text-gray-400">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <select name="category" id="public-category-filter" onchange="this.form.submit()"
                        class="w-full sm:w-48 py-2.5 px-3 text-sm bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-900 dark:text-gray-400 cursor-pointer">
                        <option value="">Sélectionner...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="hidden sm:inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900 transition-all shadow-sm">
                        Rechercher
                    </button>
                </form>
            </div>

            <!-- Books Grid Container -->
            <div id="books-container">
                @include('public.books._list')
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('public-search');
                const categorySelect = document.getElementById('public-category-filter');
                const booksContainer = document.getElementById('books-container');
                let searchTimer;

                function fetchBooks() {
                    const search = searchInput.value;
                    const category = categorySelect.value;

                    const url = new URL(window.location.href);
                    url.searchParams.set('search', search);
                    url.searchParams.set('category', category);
                    url.searchParams.delete('page'); // Reset to page 1 on filter change

                    history.pushState(null, '', url.toString());

                    fetch(url.toString(), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.text())
                        .then(html => {
                            booksContainer.innerHTML = html;
                            // Re-initialize Lucide icons for new content
                            if (window.lucide) {
                                window.lucide.createIcons();
                            }
                        })
                        .catch(error => console.error('Error fetching books:', error));
                }

                // Debounce search input
                searchInput.addEventListener('input', function () {
                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(fetchBooks, 300);
                });

                // Instant filter on category change
                categorySelect.addEventListener('change', function () {
                    fetchBooks();
                });

                // Handle pagination links click
                document.addEventListener('click', function (e) {
                    const link = e.target.closest('#pagination-container a') || e.target.closest('.pagination a');
                    if (link && booksContainer.contains(link)) {
                        e.preventDefault();

                        const url = link.href;
                        history.pushState(null, '', url);

                        fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                            .then(response => response.text())
                            .then(html => {
                                booksContainer.innerHTML = html;
                                if (window.lucide) {
                                    window.lucide.createIcons();
                                }
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                            })
                            .catch(error => console.error('Error fetching page:', error));
                    }
                });
            });
        </script>
@endsection