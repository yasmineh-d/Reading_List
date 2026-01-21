<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] font-sans antialiased h-full flex flex-col">
    <div class="min-h-full">
        <nav class="bg-white dark:bg-[#161615] border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="font-bold text-xl text-[#F53003] dark:text-[#FF4433]">
                                {{ config('app.name', 'Reading List') }}
                            </a>
                        </div>
                        <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('books.index') }}"
                                class="{{ request()->routeIs('books.*') ? 'border-[#F53003] text-[#1b1b18] dark:text-white' : 'border-transparent text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-white hover:border-[#e3e3e0]' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Books
                            </a>
                            <a href="{{ route('categories.index') }}"
                                class="{{ request()->routeIs('categories.*') ? 'border-[#F53003] text-[#1b1b18] dark:text-white' : 'border-transparent text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-white hover:border-[#e3e3e0]' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Categories
                            </a>
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <a href="{{ route('admin.books.index') }}"
                            class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            Admin
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>

        <footer class="bg-white dark:bg-[#161615] border-t border-[#e3e3e0] dark:border-[#3E3E3A] mt-auto">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Reading List') }}. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</body>

</html>