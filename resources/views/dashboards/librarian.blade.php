@extends('layouts.librarian')
@section('title', 'Librarian Dashboard')
@section('content')

<!-- Welcome Header -->
<div class="mb-8">
    <h2 class="text-3xl font-bold text-white">Welcome back, {{ $name ?? 'Librarian' }}! 👋</h2>
    <p class="text-gray-300 mt-1">Program: <span class="text-gold-400 font-semibold">Librarian</span></p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <!-- Total Books -->
    <div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10 hover:border-gold-500/30 transition-colors">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-300 text-sm">Total Books</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ number_format($stats['total'] ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-maroon-700/50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>
        <span class="text-gray-400 text-xs">Live inventory</span>
    </div>

    <!-- Available -->
    <div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10 hover:border-gold-500/30 transition-colors">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-300 text-sm">Available</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ number_format($stats['available'] ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-maroon-700/50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <span class="text-gray-400 text-xs">Ready to borrow</span>
    </div>

    <!-- Borrowed -->
    <div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10 hover:border-gold-500/30 transition-colors">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-300 text-sm">Borrowed</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ number_format($stats['borrowed'] ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-maroon-700/50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <span class="text-gray-400 text-xs">Currently out</span>
    </div>

    <!-- Overdue -->
    <div class="bg-maroon-900/50 rounded-2xl p-5 border {{ ($stats['overdue'] ?? 0) > 0 ? 'border-red-500/30' : 'border-white/10' }} hover:border-gold-500/30 transition-colors">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-300 text-sm">Overdue</p>
                <h3 class="text-3xl font-bold {{ ($stats['overdue'] ?? 0) > 0 ? 'text-red-400' : 'text-white' }} mt-2">{{ number_format($stats['overdue'] ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-maroon-700/50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>
        <span class="text-gray-400 text-xs">Needs attention</span>
    </div>

    <!-- My Borrowed -->
    <div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10 hover:border-gold-500/30 transition-colors">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-300 text-sm">My Borrowed</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ number_format($stats['myBorrowed'] ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-maroon-700/50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        </div>
        <span class="text-gray-400 text-xs">Personal loans</span>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Activity -->
    <div class="bg-maroon-900/50 rounded-2xl border border-white/10 overflow-hidden">
        <div class="px-6 py-4 border-b border-white/10 bg-maroon-950/50">
            <h3 class="text-white font-bold text-lg">Recent Activity</h3>
        </div>
        @php($now = now())
        <div class="divide-y divide-white/10">
            @forelse($recentActivity ?? [] as $a)
                @php($returned = !is_null($a->returned_at))
                @php($overdue = !$returned && $a->due_at?->lt($now))
                @php($label = $returned ? 'Returned' : ($overdue ? 'Overdue' : 'Active'))
                @php($pillClass = $returned ? 'bg-green-500/20 text-green-300' : ($overdue ? 'bg-red-500/20 text-red-300' : 'bg-amber-500/20 text-amber-300'))
                <div class="px-6 py-4 hover:bg-maroon-800/20 transition-colors">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-white text-sm">{{ $a->user?->name ?? 'Someone' }} {{ $returned ? 'returned' : 'borrowed' }} "{{ $a->book?->title ?? 'a book' }}"</p>
                            <p class="text-gray-500 text-xs mt-1">{{ $a->borrowed_at?->diffForHumans() }}</p>
                        </div>
                        <span class="px-2 py-1 {{ $pillClass }} rounded text-xs">{{ $label }}</span>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-gray-400">
                    <div class="text-4xl mb-2">📭</div>
                    <p>No activity yet.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Popular Books -->
    <div class="bg-maroon-900/50 rounded-2xl border border-white/10 overflow-hidden">
        <div class="px-6 py-4 border-b border-white/10 bg-maroon-950/50">
            <h3 class="text-white font-bold text-lg">Popular Books</h3>
        </div>
        <div class="divide-y divide-white/10">
            @forelse($popularBooks ?? [] as $p)
                <div class="px-6 py-4 hover:bg-maroon-800/20 transition-colors">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-white text-sm">{{ $p->title }}</p>
                            <p class="text-gray-500 text-xs">{{ $p->author }}</p>
                        </div>
                        <span class="text-gold-400 text-xs">{{ $p->borrows_count }} borrows</span>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-gray-400">
                    <p>No data yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
