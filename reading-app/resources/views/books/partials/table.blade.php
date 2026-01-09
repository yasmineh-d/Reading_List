@foreach ($data as $book)
    <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/50 transition-colors">
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $book->title }}</div>
        </td>
        <td class="px-6 py-4">
            <div class="text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate" title="{{ $book->description }}">
                {{ $book->description }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $book->author }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex flex-wrap gap-1">
                @foreach($book->categories as $category)
                    <span
                        class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-500">
                        {{ $category->name }}
                    </span>
                @endforeach
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
            <div class="flex justify-end items-center gap-3">
                <button type="button"
                    onclick="openModal({{ $book->id }}, '{{ addslashes($book->title) }}', '{{ addslashes($book->author) }}', '{{ addslashes($book->description) }}', [{{ $book->categories->pluck('id')->implode(',') }}])"
                    class="text-gray-400 hover:text-blue-600 transition-colors">
                    <i data-lucide="pencil" class="w-4 h-4"></i>
                </button>
                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline"
                    onsubmit="return confirm('Êtes-vous sûr ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-600 transition-colors">
                        <i data-lucide="trash" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endforeach

<script>
    if (window.lucide) {
        window.lucide.createIcons();
    }
</script>