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