@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-gray-800 dark:text-white">Gestion des Utilisateurs</h1>
                <p class="text-sm text-gray-500 mt-1">Ajouter, modifier, désactiver ou supprimer des comptes.</p>
            </div>
            <a href="#" class="py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-lg border border-transparent font-medium bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800 shadow-sm shadow-blue-500/30">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Ajouter un utilisateur
            </a>
        </div>

        <!-- Card -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
            <!-- Filters -->
            <div class="px-6 py-4 grid gap-3 md:flex md:justify-end border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-900">
                <!-- Search -->
                <div>
                     <input type="text" class="py-2 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" placeholder="Rechercher par nom...">
                </div>
                <!-- Role Filter -->
                <div>
                    <select class="py-2 px-3 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                        <option selected>Tous les rôles</option>
                        <option>Admin</option>
                        <option>Auteur</option>
                        <option>Membre</option>
                    </select>
                </div>
                 <!-- Status Filter -->
                 <div>
                    <select class="py-2 px-3 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                        <option selected>Tous les statuts</option>
                        <option>Actif</option>
                        <option>Inactif</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-white dark:bg-slate-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-bold text-gray-400 uppercase tracking-wider font-heading">Nom Complet</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-bold text-gray-400 uppercase tracking-wider font-heading">Email</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-bold text-gray-400 uppercase tracking-wider font-heading">Rôle</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-bold text-gray-400 uppercase tracking-wider font-heading">Statut</th>
                            <th scope="col" class="px-6 py-3 text-end text-xs font-bold text-gray-400 uppercase tracking-wider font-heading">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($data as $user)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $user->username }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- Mock logic for role, replace with actual user role -->
                                    <div class="text-sm text-gray-800 dark:text-gray-200">
                                        {{ $user->id == 1 ? 'Admin' : 'Auteur' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- Mock logic for status -->
                                    <span class="inline-flex items-center gap-1.5 py-0.5 px-2.5 rounded-full text-xs font-medium {{ $user->id % 2 != 0 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400' }}">
                                        {{ $user->id % 2 != 0 ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    <div class="flex justify-end items-center gap-2">
                                        <button class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-500 transition-colors">
                                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                                        </button>
                                         <button class="text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-500 transition-colors">
                                             <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        </button>
                                         <button class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500 transition-colors">
                                            <i data-lucide="user-x" class="w-4 h-4"></i>
                                        </button>
                                        <button class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500 transition-colors">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Footer / Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-900 flex justify-center">
                {{ $data->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
@endsection