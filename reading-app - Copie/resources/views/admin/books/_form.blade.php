<form id="bookForm" action="{{ isset($book) ? route('admin.books.update', $book->id) : route('admin.books.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($book))
        @method('PUT')
    @endif

    <div class="grid gap-6">
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
        
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label for="ISBN" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ISBN</label>
                <input type="text" name="ISBN" id="ISBN" value="{{ old('ISBN', $book->ISBN ?? '') }}"
                    class="w-full px-4 py-2 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-700 dark:text-gray-400"
                    placeholder="Enter ISBN number...">
                @error('ISBN')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div>
            <label for="description" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea name="description" id="description" rows="3"
                class="w-full px-4 py-2 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-700 dark:text-gray-400"
                placeholder="Enter book description...">{{ old('description', $book->description ?? '') }}</textarea>
            @error('description')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="image" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Cover Image</label>
            <input type="file" name="image" id="image"
                class="w-full px-4 py-2 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-700 dark:text-gray-400">
            
            <!-- Dynamic Image Preview Container for Edit Modal -->
            <div id="current-image-preview" class="mt-3 hidden">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Image actuelle :</p>
                <div class="relative inline-block group">
                    <img id="edit-image-preview" src="" alt="Preview" class="h-32 w-24 object-cover rounded shadow-md border dark:border-gray-600">
                    
                    <!-- X Button to remove image -->
                    <button type="button" id="remove-image-btn" 
                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 transition-colors focus:outline-none"
                        title="Delete Image">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                    
                    <!-- Hidden input to track removal -->
                    <input type="hidden" name="remove_image" id="remove_image_input" value="0">
                </div>
            </div>

            @error('image')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        

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
