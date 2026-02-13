@extends('layouts.admin')

@section('content')
    <style>
        /* Pagination Styling to match ECO Shop */
        #pagination-container nav div:last-child span.relative,
        #pagination-container nav div:last-child a.relative {
            border-radius: 6px !important;
            margin-left: 4px !important;
            border: 1px solid #e5e7eb !important;
            background-color: #ffffff !important;
            color: #374151 !important;
            padding: 6px 12px !important;
            font-size: 0.8125rem !important;
            font-weight: 500 !important;
            transition: all 0.2s;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        #pagination-container nav div:last-child span.relative[aria-current="page"] {
            background-color: #1f2937 !important;
            color: white !important;
            border-color: #1f2937 !important;
        }

        #pagination-container nav div:last-child a.relative:hover {
            background-color: #f9fafb !important;
            border-color: #d1d5db !important;
        }

        .dark #pagination-container nav div:last-child span.relative,
        .dark #pagination-container nav div:last-child a.relative {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #94a3b8 !important;
        }

        .dark #pagination-container nav div:last-child span.relative[aria-current="page"] {
            background-color: #3b82f6 !important;
            color: white !important;
        }
    </style>

    <div x-data="bookManager({ search: '{{ request('search') }}', category: '{{ request('category') }}' })"
        class="space-y-6">
        <!-- Alert Container message-->
        <div id="alert-container" class="fixed top-4 right-4 z-[9999] w-80">
            <template x-if="alert.show">
                <div :class="alert.type === 'success' ? 'bg-green-600' : 'bg-red-600'"
                    class="p-4 text-white rounded-lg shadow-xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
                    <svg x-show="alert.type === 'success'" class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <svg x-show="alert.type === 'error'" class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span x-text="alert.message"></span>
                </div>
            </template>
        </div>

        <!-- Header -->
        <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestion des Livres</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Gérez votre inventaire : ajoutez, modifiez ou supprimez
                    vos articles.</p>
            </div>
            <div>
                <button type="button" @click="openAddModal()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900 transition-all shadow-sm hover:shadow-md">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Ajouter un produit
                </button>
            </div>
        </div>


        <!-- Search & Filter Card -->
        <div class="flex items-center justify-end gap-3 mb-4">
            <div class="relative w-80">
                <input type="text" x-model="search" @input.debounce.300ms="updateTable()"
                    placeholder="Rechercher un produit..."
                    class="w-full py-2 pl-10 pr-4 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-700 dark:text-gray-400">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>
            </div>
            <select x-model="category" @change="updateTable()"
                class="py-2 px-3 text-sm bg-white border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-700 dark:text-gray-400">
                <option value="">Sélectionner...</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Books Table Card -->
        <div
            class="overflow-hidden bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-slate-900 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-slate-800">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            IMAGE</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            TITLE</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            AUTHOR</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            ISBN</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            CATEGORIES</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            DESCRIPTION</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">
                            ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="books-table-body" class="divide-y divide-gray-200 dark:divide-gray-700" x-html="tableHtml">
                    @include('admin.books._table_body')
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div id="pagination-container" class="mt-6 px-2">
            {{ $books->withQueryString()->links() }}
        </div>

        <!-- Modals -->
        @include('admin.books._modal')
    </div>

@endsection