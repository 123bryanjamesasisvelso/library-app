<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>@yield('title') - DigiLib</title><link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />@vite(['resources/css/app.css','resources/js/app.js'])</head>
<body class="bg-library-dark min-h-screen flex relative" style="background-image: url('{{ asset('images/libraryngani.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
<div class="fixed inset-0 -z-10">
    <div class="absolute inset-0 bg-black/55"></div>
</div>
<aside class="w-64 bg-library-sidebar min-h-screen flex flex-col fixed left-0 top-0 z-40">
<div class="p-6 border-b border-white/10"><div class="flex items-center gap-3"><div class="w-10 h-10 bg-maroon-600 rounded-xl flex items-center justify-center text-white font-bold">DL</div><div><h2 class="text-white font-bold text-lg">DigiLib</h2><p class="text-gray-400 text-xs">Admin Panel</p></div></div></div>
<nav class="flex-1 p-4 space-y-1">
<a href="{{url('/admin/dashboard')}}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-library-hover hover:text-white rounded-xl{{request()->is('admin/dashboard')?' bg-library-hover text-white font-medium':''}}">Dashboard</a>
<a href="{{url('/admin/users')}}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-library-hover hover:text-white rounded-xl{{request()->is('admin/users')?' bg-library-hover text-white font-medium':''}}">Users</a>
<a href="{{url('/admin/books')}}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-library-hover hover:text-white rounded-xl{{request()->is('admin/books')?' bg-library-hover text-white font-medium':''}}">Books</a>
<a href="{{url('/admin/profile')}}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-library-hover hover:text-white rounded-xl{{request()->is('admin/profile')?' bg-library-hover text-white font-medium':''}}">Profile</a>
</nav>
<div class="p-4 border-t border-white/10 space-y-3">
    <div class="flex items-center gap-3">
        <div class="w-9 h-9 bg-maroon-500 rounded-full flex items-center justify-center text-white font-bold text-sm">A</div>
        <div>
            <p class="text-white text-sm font-medium">{{ auth()->user()->name ?? 'Admin User' }}</p>
            <p class="text-gray-500 text-xs">{{ auth()->user()->email ?? 'admin@library.com' }}</p>
        </div>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full px-4 py-2.5 bg-white/5 text-gray-200 rounded-xl hover:bg-white/10 transition-colors text-sm font-medium">
            Logout
        </button>
    </form>
</div>
</aside>
<main class="flex-1 ml-64">
<header class="border-b border-white/5 px-8 py-4"><h1 class="text-white text-xl font-bold">@yield('header')</h1></header>
<div class="p-8">@yield('content')</div>
</main>
</body></html>
