@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-gray-800 dark:text-white">Gestion des Livres</h1>
                <p class="text-sm text-gray-500 mt-1">Ajouter, modifier ou supprimer des livres de votre collection.</p>
            </div>
            <button type="button" onclick="openModal()" class="py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-lg border border-transparent font-medium bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800 shadow-sm shadow-blue-500/30">
                <i data-lucide="plus" class="w-4 h-4"></i> Ajouter un livre
            </button>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-200 text-green-800 rounded-lg p-4 dark:bg-green-900/30 dark:border-green-800 dark:text-green-400" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Card -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
            <!-- Filters -->
            <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-900">
                <div class="flex items-center gap-3 w-full">
                    <div class="relative w-64">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </div>
                        <input type="text" id="search-input" name="search" value="{{ request('search') }}" class="py-2 pl-10 pr-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:placeholder-gray-500" placeholder="Rechercher par titre...">
                    </div>
                    
                    <select id="category-filter" name="category" class="py-2 px-4 block w-48 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Results Container (Table + Pagination) -->
            <div id="results-container">
                @include('books.partials.results')
            </div>
        </div>
    </div>

    <!-- Book Modal -->
    <div id="book-modal" class="fixed inset-0 z-[80] hidden overflow-y-auto bg-gray-900/50 backdrop-blur-sm">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg w-full max-w-lg dark:bg-slate-900 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center dark:border-gray-700">
                    <h3 id="modal-title" class="text-lg font-bold text-gray-800 dark:text-white">Ajouter un livre</h3>
                    <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form id="book-form" action="{{ route('books.store') }}" method="POST">
                    @csrf
                    <div id="method-container"></div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-bold mb-2 dark:text-white">Titre</label>
                            <input type="text" id="title" name="title" class="py-3 px-4 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" required>
                        </div>
                        <div>
                            <label for="author" class="block text-sm font-bold mb-2 dark:text-white">Auteur</label>
                            <input type="text" id="author" name="author" class="py-3 px-4 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-white">Catégories</label>
                            <div class="grid grid-cols-2 gap-2 mt-2 max-h-40 overflow-y-auto p-2 border rounded-lg dark:border-gray-700">
                                @foreach($categories as $category)
                                    <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400 cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-800 p-1 rounded transition-colors">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="category-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        {{ $category->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div id="full-fields">
                            <div>
                                <label for="ISBN" class="block text-sm font-bold mb-2 dark:text-white">ISBN</label>
                                <input type="text" id="ISBN" name="ISBN" class="py-3 px-4 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                            </div>
                            <div class="mt-4">
                                <label for="publication_date" class="block text-sm font-bold mb-2 dark:text-white">Date de publication</label>
                                <input type="date" id="publication_date" name="publication_date" class="py-3 px-4 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                            </div>
                            <input type="hidden" name="user_id" value="1">
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-bold mb-2 dark:text-white">Description</label>
                            <textarea id="description" name="description" rows="4" class="py-3 px-4 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" required></textarea>
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end gap-2 rounded-b-xl dark:bg-slate-900/50 dark:border-gray-700">
                        <button type="button" onclick="closeModal()" class="py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none transition-all text-sm dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white">
                            Annuler
                        </button>
                        <button type="submit" class="py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-lg border border-transparent font-semibold bg-blue-600 text-white hover:bg-blue-700 focus:outline-none transition-all text-sm shadow-sm shadow-blue-500/30">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Open Modal
        function openModal(id = null, titleVal = '', authorVal = '', descVal = '', categoryIds = []) {
            const modal = document.getElementById('book-modal');
            const form = document.getElementById('book-form');
            const modalTitle = document.getElementById('modal-title');
            const methodContainer = document.getElementById('method-container');
            const fullFields = document.getElementById('full-fields');
            const checkboxes = document.querySelectorAll('.category-checkbox');

            if (id) {
                modalTitle.innerText = 'Modifier le livre';
                form.action = `/books/${id}`;
                methodContainer.innerHTML = '@method("PUT")';
                fullFields.style.display = 'none';
                document.getElementById('ISBN').required = false;
                document.getElementById('publication_date').required = false;
            } else {
                modalTitle.innerText = 'Ajouter un livre';
                form.action = "{{ route('books.store') }}";
                methodContainer.innerHTML = '';
                fullFields.style.display = 'block';
                document.getElementById('ISBN').required = true;
                document.getElementById('publication_date').required = true;
            }

            document.getElementById('title').value = titleVal;
            document.getElementById('author').value = authorVal;
            document.getElementById('description').value = descVal;

            // Reset and set checkboxes
            checkboxes.forEach(cb => {
                cb.checked = categoryIds.includes(parseInt(cb.value));
            });

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('book-modal').classList.add('hidden');
        }

        // Live Search logic
        const searchInput = document.getElementById('search-input');
        const categoryFilter = document.getElementById('category-filter');
        const resultsContainer = document.getElementById('results-container');

        function fetchResults() {
            const search = searchInput.value;
            const category = categoryFilter.value;
            
            const url = new URL("{{ route('books.index') }}", window.location.origin);
            url.searchParams.set('search', search);
            if (category) url.searchParams.set('category', category);

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                resultsContainer.innerHTML = html;
            });
        }

        searchInput.addEventListener('input', fetchResults);
        categoryFilter.addEventListener('change', fetchResults);

        // Close on backdrop
        window.onclick = function(event) {
            const modal = document.getElementById('book-modal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
@endsection