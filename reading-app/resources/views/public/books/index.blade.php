@extends('layouts.public')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Library</h1>

            <form action="{{ route('books.index') }}" method="GET" class="flex gap-2">
                <select name="category"
                    class="rounded-md border-[#e3e3e0] dark:border-[#3E3E3A] px-3 py-2 text-sm bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] focus:border-[#F53003] focus:ring-[#F53003]">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="search" placeholder="Search books..." value="{{ request('search') }}"
                    class="rounded-md border-[#e3e3e0] dark:border-[#3E3E3A] px-3 py-2 text-sm bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] focus:border-[#F53003] focus:ring-[#F53003] w-full md:w-64">

                <button type="submit"
                    class="bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1b1b18] px-4 py-2 rounded-md text-sm font-medium hover:opacity-90">
                    Filter
                </button>
            </form>
        </div>

        @if($books->isEmpty())
            <div class="text-center py-12">
                <p class="text-[#706f6c] dark:text-[#A1A09A]">No books found matching your criteria.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($books as $book)
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
                                {{ $book->title }}
                            </h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-2">{{ $book->author }}</p>

                            <div class="flex flex-wrap gap-1">
                                @foreach($book->categories as $category)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-[#F53003]/10 text-[#F53003]">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $books->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection