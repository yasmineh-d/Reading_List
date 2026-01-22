@extends('layouts.public')

@section('content')
    <div class="space-y-6">
        <div class="text-center max-w-2xl mx-auto py-8">
            <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">Explore Categories</h1>
            <p class="text-[#706f6c] dark:text-[#A1A09A]">Browse our collection by category to find your next favorite read.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('books.index', ['category' => $category->id]) }}"
                    class="group block p-6 bg-white dark:bg-[#161615] rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] hover:border-[#F53003] dark:hover:border-[#F53003] transition-colors relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-[#F53003]/5 rounded-full blur-2xl group-hover:bg-[#F53003]/10 transition-colors">
                    </div>

                    <div class="relative z-10">
                        <h3
                            class="text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-2 group-hover:text-[#F53003] transition-colors">
                            {{ $category->name }}</h3>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            {{ $category->books_count }} books
                        </p>
                    </div>

                    <div
                        class="absolute bottom-6 right-6 opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all duration-300">
                        <svg class="w-6 h-6 text-[#F53003]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                            </path>
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection