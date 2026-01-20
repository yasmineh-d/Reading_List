<form id="bookForm" action="{{ isset($book) ? route('admin.books.update', $book->id) : route('admin.books.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($book))
        @method('PUT')
    @endif

    <div class="grid gap-6">
        <!-- Title & Author -->
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label for="title" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Book Title
                    <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $book->title ?? '') }}" required
                    class="w-full px-4 py-2 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-700 dark:text-gray-400">
                @error('title')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="author" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Author <span
                        class="text-red-500">*</span></label>
                <input type="text" name="author" id="author" value="{{ old('author', $book->author ?? '') }}" required
                    class="w-full px-4 py-2 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-700 dark:text-gray-400">
                @error('author')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- ISBN & Pub Date -->
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label for="ISBN" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ISBN</label>
                <input type="text" name="ISBN" id="ISBN" value="{{ old('ISBN', $book->ISBN ?? '') }}"
                    class="w-full px-4 py-2 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-700 dark:text-gray-400">
                @error('ISBN')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            {{-- <div>
                <label for="publication_date"
                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Publication Date</label>
                <input type="date" name="publication_date" id="publication_date"
                    value="{{ old('publication_date', $book->publication_date ?? '') }}"
                    class="w-full px-4 py-2 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-700 dark:text-gray-400">
                @error('publication_date')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div> --}}
        </div>

        <!-- Image URL -->
        <div>
            <label for="image" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Cover Image
                URL</label>
            <input type="file" name="image" id="image"
                class="w-full px-4 py-2 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-700 dark:text-gray-400">
            @if(isset($book) && $book->image)
                <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Current image:
                    <img src="{{ $book->image }}" alt="Preview" class="h-20 mt-1 rounded shadow-sm">
                </div>
            @endif
            @error('image')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Categories -->
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Categories</label>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                @foreach($categories as $category)
                    <div
                        class="flex items-center p-2 border border-gray-200 rounded-lg dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat-{{ $category->id }}"
                            class="shrink-0 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                            {{ in_array($category->id, old('categories', isset($book) ? $book->categories->pluck('id')->toArray() : [])) ? 'checked' : '' }}>
                        <label for="cat-{{ $category->id }}"
                            class="text-sm text-gray-700 ms-3 w-full cursor-pointer dark:text-gray-300">
                            {{ $category->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('categories')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>
</form>