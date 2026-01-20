@forelse($books as $book)
    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center gap-4">
                @if($book->image)
                    <img class="w-10 h-14 object-cover rounded shadow-sm" src="{{ $book->image }}" alt="{{ $book->title }}">
                @else
                    <div class="flex items-center justify-center w-10 h-14 bg-gray-100 rounded text-gray-400 dark:bg-slate-800">
                        <i data-lucide="image" class="w-5 h-5"></i>
                    </div>
                @endif
                <div>
                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $book->title }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">ISBN: {{ $book->ISBN ?? 'N/A' }}</div>
                </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
            {{ $book->author }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex flex-wrap gap-2">
                @foreach($book->categories as $bg_cat)
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                        {{ $bg_cat->name }}
                    </span>
                @endforeach
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
            <div class="flex flex-col items-center justify-center">
                <i data-lucide="book-off" class="w-10 h-10 mb-2 text-gray-300 dark:text-gray-600"></i>
                <p>No books found matching your criteria.</p>
            </div>
        </td>
    </tr>
@endforelse