@extends('layouts.public')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('books.index') }}"
                class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] inline-flex items-center text-sm font-medium">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Back to Library
            </a>
        </div>

        <div
            class="bg-white dark:bg-[#161615] rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] overflow-hidden shadow-sm">
            <div class="grid md:grid-cols-3 gap-0">
                <div
                    class="col-span-1 bg-gray-50 dark:bg-[#1b1b18] p-6 md:p-8 flex items-start justify-center border-b md:border-b-0 md:border-r border-[#e3e3e0] dark:border-[#3E3E3A]">
                    <div class="w-48 shadow-xl rounded-lg overflow-hidden">
                        @if($book->image)
                            <img src="{{ $book->image }}" alt="{{ $book->title }}" class="w-full h-auto object-cover">
                        @else
                            <div
                                class="aspect-[2/3] bg-gray-200 dark:bg-[#2C2C2A] flex items-center justify-center text-[#706f6c] dark:text-[#A1A09A]">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-span-2 p-6 md:p-8">
                    <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">{{ $book->title }}</h1>
                    <p class="text-xl text-[#706f6c] dark:text-[#A1A09A] mb-6">by <span
                            class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">{{ $book->author }}</span></p>

                    <div class="space-y-6">
                        <div>
                            <h3
                                class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC] uppercase tracking-wider mb-3">
                                Categories</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($book->categories as $category)
                                    <a href="{{ route('books.index', ['category' => $category->id]) }}"
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-[#efefec] dark:bg-[#2C2C2A] text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-[#e3e3e0] dark:hover:bg-[#3E3E3A] transition-colors">
                                        {{ $category->label }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        @if($book->description)
                            <div>
                                <h3
                                    class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC] uppercase tracking-wider mb-3">
                                    About this book</h3>
                                <div class="prose dark:prose-invert max-w-none text-[#706f6c] dark:text-[#A1A09A]">
                                    <p>{{ $book->description }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-4 pt-6 border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
                            @if($book->publication_date)
                                <div>
                                    <dt class="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">Published</dt>
                                    <dd class="mt-1 text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                                        {{ \Carbon\Carbon::parse($book->publication_date)->format('F j, Y') }}</dd>
                                </div>
                            @endif

                            @if($book->ISBN)
                                <div>
                                    <dt class="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">ISBN</dt>
                                    <dd class="mt-1 text-sm text-[#1b1b18] dark:text-[#EDEDEC]">{{ $book->ISBN }}</dd>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection