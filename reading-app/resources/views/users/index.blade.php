@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold font-heading text-gray-800 dark:text-white">Gestion des Utilisateurs</h1>
                <p class="text-sm text-gray-500 mt-1">Ajouter, modifier, désactiver ou supprimer des comptes.</p>
            </div>
            <button type="button" onclick="openModal()" class="py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-lg border border-transparent font-medium bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800 shadow-sm shadow-blue-500/30">
                <i data-lucide="plus" class="w-4 h-4"></i>+ Ajouter un utilisateur
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
            <div class="px-6 py-4 grid gap-3 md:flex md:justify-end border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-900">
                <!-- Search -->
                <div>
                     <form action="{{ route('users.index') }}" method="GET">
                        <input type="text" name="search" value="{{ request('search') }}" class="py-2 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" placeholder="Rechercher par nom...">
                     </form>
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
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $loop->index % 2 == 0 ? 'Admin' : 'Auteur' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($loop->index % 2 == 0)
                                        <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-500">
                                            Actif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400">
                                            Inactif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    <div class="flex justify-end items-center gap-3">
                                        <button type="button" onclick="openModal({{ $user->id }}, '{{ $user->username }}', '{{ $user->email }}')" class="text-gray-400 hover:text-blue-600 transition-colors">
                                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                                        </button>
                                        <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors">
                                            <i data-lucide="badge-check" class="w-4 h-4"></i>
                                        </button>
                                        @if($loop->index % 2 == 0)
                                            <button type="button" class="text-red-500 hover:text-red-600 transition-colors">
                                                <i data-lucide="user-x" class="w-4 h-4"></i>
                                            </button>
                                        @else
                                            <button type="button" class="text-green-500 hover:text-green-600 transition-colors">
                                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                            </button>
                                        @endif
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600 transition-colors">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
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

    <!-- User Modal -->
    <div id="user-modal" class="fixed inset-0 z-[80] hidden overflow-y-auto bg-gray-900/50 backdrop-blur-sm">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg w-full max-w-lg dark:bg-slate-900 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center dark:border-gray-700">
                    <h3 id="modal-title" class="text-lg font-bold text-gray-800 dark:text-white">Ajouter un utilisateur</h3>
                    <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form id="user-form" action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div id="method-container"></div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="username" class="block text-sm font-medium mb-2 dark:text-white">Nom d'utilisateur</label>
                            <input type="text" id="username" name="username" class="py-2.5 px-4 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium mb-2 dark:text-white">Email</label>
                            <input type="email" id="email" name="email" class="py-2.5 px-4 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" required>
                        </div>
                        <div id="password-field">
                            <label for="password" class="block text-sm font-medium mb-2 dark:text-white">Mot de passe</label>
                            <input type="password" id="password" name="password" class="py-2.5 px-4 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end gap-2 rounded-b-xl dark:bg-slate-900/50 dark:border-gray-700">
                        <button type="button" onclick="closeModal()" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none transition-all text-sm dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white">
                            Annuler
                        </button>
                        <button type="submit" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-lg border border-transparent font-semibold bg-blue-600 text-white hover:bg-blue-700 focus:outline-none transition-all text-sm shadow-sm shadow-blue-500/30">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(id = null, username = '', email = '') {
            const modal = document.getElementById('user-modal');
            const form = document.getElementById('user-form');
            const title = document.getElementById('modal-title');
            const methodContainer = document.getElementById('method-container');
            const passwordField = document.getElementById('password-field');

            if (id) {
                title.innerText = 'Modifier l\'utilisateur';
                form.action = `/users/${id}`;
                methodContainer.innerHTML = '@method("PUT")';
                passwordField.style.display = 'none';
                document.getElementById('password').required = false;
            } else {
                title.innerText = 'Ajouter un utilisateur';
                form.action = "{{ route('users.store') }}";
                methodContainer.innerHTML = '';
                passwordField.style.display = 'block';
                document.getElementById('password').required = true;
            }

            document.getElementById('username').value = username;
            document.getElementById('email').value = email;

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('user-modal').classList.add('hidden');
        }

        // Close modal on click outside
        window.onclick = function(event) {
            const modal = document.getElementById('user-modal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
@endsection
