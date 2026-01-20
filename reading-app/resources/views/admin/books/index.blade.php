@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold font-heading text-gray-800 dark:text-white">Books</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Manage your book collection</p>
            </div>
            <div>
                <button type="button"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900 transition-all shadow-md hover:shadow-lg"
                    data-hs-overlay="#hs-slide-down-animation-modal">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Add New Book
                </button>
            </div>
        </div>

        <div class="p-4 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-slate-900 dark:border-gray-700">
            <form action="{{ route('admin.books.index') }}" method="GET" class="grid gap-4 md:grid-cols-3">
                <div class="relative">
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Search title..."
                        class="w-full py-2 pl-10 pr-4 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-700 dark:text-gray-400">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                    </div>
                </div>
            </form>
        </div>

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
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @include('admin.books._table_body')
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $books->withQueryString()->links() }}
        </div>

        @include('admin.books._modal')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            const tableBody = document.querySelector('tbody');

            function fetchBooks() {
                const search = searchInput.value;

                const url = new URL(window.location.href);
                url.searchParams.set('search', search);
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

            function debounce(func, delay = 500) {
                let timer;
                return (...args) => {
                    clearTimeout(timer);
                    timer = setTimeout(() => func.apply(this, args), delay);
                };
            }

            searchInput.addEventListener('input', debounce(fetchBooks));
        });
    </script>

@endsection