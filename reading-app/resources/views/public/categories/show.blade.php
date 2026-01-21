@extends('layouts.public')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <a href="{{ route('categories.index') }}"
                        class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] text-sm font-medium">Categories</a>
                    <span class="text-[#e3e3e0] dark:text-[#3E3E3A]">/</span>
                    <span class="text-[#1b1b18] dark:text-[#EDEDEC] text-sm font-medium">{{ $category->label }}</span>
                </div>
                <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $category->label }}</h1>
            </div>

            <a href="{{ route('books.index', ['category' => $category->id]) }}"
                class="text-[#F53003] hover:text-[#D12902] font-medium text-sm inline-flex items-center">
                View as List
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                    </path>
                </svg>
            </a>
        </div>

        @if($category->books->isEmpty())
            <div class="text-center py-12 bg-white dark:bg-[#161615] rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A]">
                <p class="text-[#706f6c] dark:text-[#A1A09A]">No books available in this category yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($category->books as $book)
                    <a href="{{ route('books.show', $book->id) }}"
                        class="group block bg-white dark:bg-[#161615] rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="aspect-[2/3] bg-gray-100 dark:bg-[#1b1b18] relative overflow-hidden">
                            @if($book->image)
                                <img src="{{ $book->image }}" alt="{{ $book->title }}"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center text-[#706f6c] dark:text-[#A1A09A]">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3
                                class="font-bold text-lg text-[#1b1b18] dark:text-[#EDEDEC] mb-1 line-clamp-1 group-hover:text-[#F53003] transition-colors">
                                {{ $book->title }}</h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-2">{{ $book->author }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection