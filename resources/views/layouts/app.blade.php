{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIMAEL | @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Stack+Sans+Headline:wght@200..700&display=swap" rel="stylesheet">

    <!-- AOS Animation CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

     <!-- Alpine.js for custom dropdowns -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Stack Sans Headline', sans-serif;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">

    {{-- Navbar --}}
    <nav class="fixed w-full bg-white border-b border-gray-200 z-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="flex justify-between h-16 items-center gap-6">
                <!-- Logo & Brand -->
                <div class="flex items-center flex-shrink-0 w-32">
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">SIMAEL</h1>
                        <p class="text-xs text-gray-500">
                            @student
                                Student Dashboard
                            @else
                                @teacher
                                    Teacher Dashboard
                                    @else
                                    Sistem Manajemen Pintar PKL
                                @endteacher
                            @endstudent
                        </p>
                    </div>
                </div>

                {{-- Navbar Items (Landing Page) - Centered --}}
                <div class="hidden md:flex items-center space-x-6 flex-1 justify-center">
                    @yield('navbar-items')
                </div>

                <!-- Right Side Navigation - Fixed Width -->
                <div class="flex items-center space-x-4 flex-shrink-0 w-32 justify-end">
                    @student
                        <!-- Home Link for Student -->
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="text-sm font-medium hidden sm:inline">Home</span>
                        </a>
                        <!-- Logout Link for Student -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="text-sm font-medium hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    @else
                    @teacher
                        <!-- Home Link for Teacher -->
                        <a href="{{ route('teacher.dashboard') }}" class="flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="text-sm font-medium hidden sm:inline">Home</span>
                        </a>
                        <!-- Logout Link for Teacher -->
                        <form method="POST" action="{{ route('teacher.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="text-sm font-medium hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    @else
                        <!-- Guest Navigation -->
                        <a href="{{ route('login') }}" class="group relative inline-block text-gray-700 font-medium text-sm transition duration-200 ease-in-out">
                            Login
                        </a>
                    @endteacher
                    @endstudent
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="pt-16">
        @yield('content')
    </main>

    {{-- Scripts --}}
    @stack('scripts')
</body>
</html>
