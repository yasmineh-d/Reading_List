@if($books->isEmpty())
    <div class="text-center py-24 bg-white dark:bg-slate-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-slate-800 mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                </path>
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">No books found</h3>
        <p class="text-gray-500 dark:text-gray-400">
            Try adjusting your search or filters.
        </p>
        @if(request('search') || request('category'))
            <a href="{{ route('books.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">
                Clear all filters
            </a>
        @endif
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($books as $book)
            <a href="{{ route('books.show', $book->id) }}"
                class="group block bg-white dark:bg-slate-900 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow duration-300 h-full flex flex-col">
                <div class="aspect-square bg-gray-100 dark:bg-slate-800 relative overflow-hidden">
                    @if($book->image)
                        <img src="{{ Str::startsWith($book->image, ['http', 'https', '/', 'storage']) ? $book->image : asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                            onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'absolute inset-0 flex items-center justify-center text-gray-400 bg-gray-100 dark:bg-slate-800\'><svg class=\'w-12 h-12\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253\'></path></svg></div>';">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-4 flex-1 flex flex-col">
                    <h3
                        class="font-bold text-lg text-gray-900 dark:text-white mb-1 line-clamp-2 group-hover:text-blue-600 transition-colors">
                        {{ $book->title }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3 line-clamp-1">{{ $book->author }}</p>
                    @if($book->categories->isNotEmpty())
                        <div class="flex flex-wrap gap-1 mt-auto">
                            @foreach($book->categories->take(2) as $category)
                                <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                            @if($book->categories->count() > 2)
                                <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                                    +{{ $book->categories->count() - 2 }}
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $books->withQueryString()->links() }}
    </div>
@endif
