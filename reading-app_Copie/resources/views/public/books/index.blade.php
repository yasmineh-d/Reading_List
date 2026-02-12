@extends('layouts.public')

@section('content')
    <div x-data="publicBookManager({ search: '{{ request('search') }}', category: '{{ request('category') }}' })"
        class="space-y-8">
        <!-- Header & Search -->
        <div class="text-center max-w-2xl mx-auto pt-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Library</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8">
                Explore our collection of {{ $books->total() }} books across various genres.
            </p>

            <!-- Search & Filter -->
            <div class="max-w-2xl mx-auto mb-8">
                <div class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="relative flex-1 w-full">
                        <input type="text" x-model="search" @input.debounce.300ms="fetchBooks()"
                            placeholder="Rechercher par titre..."
                            class="w-full py-2.5 pl-10 pr-4 text-sm bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-900 dark:text-gray-400">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <select x-model="category" @change="fetchBooks()"
                        class="w-full sm:w-48 py-2.5 px-3 text-sm bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-900 dark:text-gray-400 cursor-pointer">
                        <option value="">Sélectionner...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Books Grid Container -->
            <div id="books-container" x-html="booksHtml">
                @include('public.books._list')
            </div>
        </div>

@endsection