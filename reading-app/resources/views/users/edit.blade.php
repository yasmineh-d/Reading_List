@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-slate-900 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Modifier l'utilisateur</h2>
            </div>

            <div class="p-6">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="username" class="block text-sm font-medium mb-2 dark:text-white">Nom
                                d'utilisateur</label>
                            <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                                required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium mb-2 dark:text-white">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                                required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="role" class="block text-sm font-medium mb-2 dark:text-white">Rôle</label>
                                <select id="role" name="role"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                    <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="Auteur" {{ $user->role == 'Auteur' ? 'selected' : '' }}>Auteur</option>
                                    <option value="Membre" {{ $user->role == 'Membre' ? 'selected' : '' }}>Membre</option>
                                </select>
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium mb-2 dark:text-white">Statut</label>
                                <select id="status" name="status"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                    <option value="Actif" {{ $user->status == 'Actif' ? 'selected' : '' }}>Actif</option>
                                    <option value="Inactif" {{ $user->status == 'Inactif' ? 'selected' : '' }}>Inactif
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-x-3">
                        <a href="{{ route('users.index') }}"
                            class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                            Annuler
                        </a>
                        <button type="submit"
                            class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-lg border border-transparent font-semibold bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection