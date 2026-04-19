<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>@yield('title') - DigiLib</title><link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />@vite(['resources/css/app.css','resources/js/app.js'])</head>
<body class="bg-maroon-800 min-h-screen relative" style="background-image: url('{{ asset('images/libraryngani.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
<div class="fixed inset-0 -z-10">
    <div class="absolute inset-0 bg-black/55"></div>
</div>
<nav class="bg-maroon-900 border-b border-white/10 px-6 py-4 flex items-center justify-between">
<div class="flex items-center gap-3"><div class="w-10 h-10 bg-maroon-600 rounded-xl flex items-center justify-center text-white font-bold">DL</div><h2 class="text-white font-bold text-lg">DigiLib</h2></div>
<div class="flex items-center gap-6">
<a href="{{url('/librarian/dashboard')}}" class="text-gray-300 hover:text-white text-sm">Dashboard</a>
<a href="{{url('/librarian/books')}}" class="text-gray-300 hover:text-white text-sm">Books</a>
<a href="{{url('/librarian/profile')}}" class="text-gray-300 hover:text-white text-sm">Profile</a>
<div class="w-9 h-9 bg-maroon-500 rounded-full flex items-center justify-center text-white font-bold text-sm ml-4">L</div>
</div>
</nav>
<main class="p-8">@yield('content')</main>
</body></html>
