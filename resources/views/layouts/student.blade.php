<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - DigiLib</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-maroon-900 min-h-screen relative" style="background-image: url('{{ asset('images/libraryngani.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="fixed inset-0 -z-10">
        <div class="absolute inset-0 bg-black/55"></div>
    </div>

    <!-- Top Navigation -->
    <nav class="relative z-20 bg-maroon-950 border-b border-white/10 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-maroon-600 rounded-xl flex items-center justify-center text-white font-bold">DL</div>
            <h2 class="text-white font-bold text-lg">DigiLib</h2>
        </div>
        <div class="flex items-center gap-6">
            <a href="{{ url('/student/dashboard') }}" class="text-gray-300 hover:text-white text-sm {{ request()->is('student/dashboard') ? 'text-white font-medium' : '' }}">Dashboard</a>
            <a href="{{ url('/student/books') }}" class="text-gray-300 hover:text-white text-sm {{ request()->is('student/books*') ? 'text-white font-medium' : '' }}">Books</a>
            <a href="{{ url('/student/fines') }}" class="text-gray-300 hover:text-white text-sm {{ request()->is('student/fines*') ? 'text-white font-medium' : '' }}">Fines</a>
            <form method="POST" action="{{ route('logout') }}" class="ml-4">
                @csrf
                <button class="text-gray-300 hover:text-white text-sm">Logout</button>
            </form>
            <div class="w-9 h-9 bg-maroon-500 rounded-full flex items-center justify-center text-white font-bold text-sm ml-2">
                {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
            </div>
        </div>
    </nav>

    <main class="relative z-10 p-8 min-h-screen">
        @yield('content')
    </main>
</body>
</html>

