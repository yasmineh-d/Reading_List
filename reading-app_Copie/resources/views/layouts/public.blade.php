<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Reading List') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-gray-100 font-sans antialiased h-full flex flex-col">
    <div class="min-h-full">
        <nav class="bg-white dark:bg-slate-900 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a class="flex items-center gap-x-2 text-xl font-bold dark:text-white" href="{{ route('home') }}"
                                aria-label="Brand">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 rounded-md">
                                <span>Book<span class="text-blue-600">Hub</span></span>
                            </a>
                        </div>
                        <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                            <!-- Navigation simplifiée -->
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        @auth
                            <div class="relative ml-3">
                                <div>
                                    <button onclick="toggleUserMenu()" type="button"
                                        class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                        id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold uppercase">
                                            {{ substr(Auth::user()->username, 0, 1) }}
                                        </div>
                                    </button>
                                </div>
                                <div id="user-dropdown" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu">
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.books.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Dashboard Admin</a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Logout</button>
                                    </form>
                                </div>
                            </div>
                            <script>
                                function toggleUserMenu() {
                                    const dropdown = document.getElementById('user-dropdown');
                                    dropdown.classList.toggle('hidden');
                                }
                                // Close dropdown when clicking outside (if not already defined)
                                if (!window.userDropdownListenerAdded) {
                                    document.addEventListener('click', function(event) {
                                        const button = document.getElementById('user-menu-button');
                                        const dropdown = document.getElementById('user-dropdown');
                                        if (button && dropdown && !button.contains(event.target) && !dropdown.contains(event.target)) {
                                            dropdown.classList.add('hidden');
                                        }
                                    });
                                    window.userDropdownListenerAdded = true;
                                }
                            </script>
                        @else
                            <div class="relative ml-3">
                                <div>
                                    <button onclick="toggleGuestMenu()" type="button"
                                        class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                        id="guest-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div id="guest-dropdown" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu">
                                    <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                            </svg>
                                            Se connecter
                                        </div>
                                    </a>
                                    <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                            S'enregistrer
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <script>
                                function toggleGuestMenu() {
                                    const dropdown = document.getElementById('guest-dropdown');
                                    dropdown.classList.toggle('hidden');
                                }
                                // Close dropdown when clicking outside
                                document.addEventListener('click', function(event) {
                                    const button = document.getElementById('guest-menu-button');
                                    const dropdown = document.getElementById('guest-dropdown');
                                    if (button && dropdown && !button.contains(event.target) && !dropdown.contains(event.target)) {
                                        dropdown.classList.add('hidden');
                                    }
                                });
                            </script>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>

        <footer class="bg-white dark:bg-slate-900 border-t border-gray-200 dark:border-gray-700 mt-auto">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Reading List') }}. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
    <script>
        window.addEventListener('load', () => {
            if (window.lucide && window.lucide.createIcons && window.lucide.icons) {
                window.lucide.createIcons({
                    icons: window.lucide.icons
                });
            }
        });
    </script>
</body>

</html>