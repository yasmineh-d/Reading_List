@forelse($books as $book)
    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
        <!-- Image Column -->
        <td class="px-6 py-4 whitespace-nowrap">
            @if($book->image)
                <img class="w-12 h-12 object-cover rounded" src="{{ $book->image }}" alt="{{ $book->title }}">
            @else
                <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded text-gray-400 dark:bg-slate-800">
                    <i data-lucide="image" class="w-5 h-5"></i>
                </div>
            @endif
        </td>
        
        <!-- Désignation Column (Title + Author) -->
        <td class="px-6 py-4">
            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $book->title }}</div>
        </td>
        
        <!-- Prix Column (mapped to ISBN) -->
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-bold text-green-600">{{ $book->ISBN ?? 'N/A' }}</div>
        </td>
        
        <!-- Catégorie Column -->
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex flex-wrap gap-1">
                @foreach($book->categories->take(2) as $bg_cat)
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                        {{ $bg_cat->name }}
                    </span>
                @endforeach
            </div>
        </td>
        
        <!-- Description Column -->
        <td class="px-6 py-4">
            <div class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                {{ Str::limit($book->description ?? 'Découvrez ' . $book->title . ', un smartphone phare...', 80) }}
            </div>
        </td>
        
        <!-- Actions Column -->
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <div class="flex items-center justify-end gap-2">
                <button onclick="openEditModal({{ $book->id }})" data-hs-overlay="#hs-add-book-modal"
                    class="p-1.5 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded transition-colors dark:text-blue-400 dark:hover:bg-blue-900/30"
                    title="Edit">
                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                </button>
                <button onclick="deleteBook({{ $book->id }})"
                    class="p-1.5 text-red-600 hover:text-red-700 hover:bg-red-50 rounded transition-colors dark:text-red-400 dark:hover:bg-red-900/30"
                    title="Delete">
                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
            <div class="flex flex-col items-center justify-center">
                <i data-lucide="book-off" class="w-10 h-10 mb-2 text-gray-300 dark:text-gray-600"></i>
                <p>Aucun livre trouvé.</p>
            </div>
        </td>
    </tr>
@endforelse