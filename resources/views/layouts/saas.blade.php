<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SmartQueue AI')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="bg-[#F8FAFC] text-[#0F172A]">
    @auth
    @php
        $user = auth()->user();
        $currentCompany = $user->currentCompany ?? $user->getDefaultCompany();
    @endphp
    @if($currentCompany)
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="flex items-center">
                        <div class="w-8 h-8 bg-[#2563EB] rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">SQ</span>
                        </div>
                        <span class="ml-3 font-bold text-slate-900">SmartQueue AI</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-slate-600">{{ $user->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    @endif
    @endauth

    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
