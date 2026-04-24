@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')

<!-- Welcome Header -->
<div class="mb-8">
    <h2 class="text-3xl font-bold text-white">Welcome back, {{ $adminName ?? 'Admin' }}! 👋</h2>
    <p class="text-gray-300 mt-1">Program: <span class="text-gold-400 font-semibold">Administrator</span></p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <!-- Total Users -->
    <div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10 hover:border-gold-500/30 transition-colors">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-300 text-sm">Total Users</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ number_format($stats['totalUsers'] ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-maroon-700/50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
        <span class="{{ ($stats['usersChange'] ?? 0) >= 0 ? 'text-green-400' : 'text-red-400' }} text-xs">{{ number_format($stats['usersChange'] ?? 0, 1) }}%</span>
        <span class="text-gray-400 text-xs ml-1">vs last 30 days</span>
    </div>

    <!-- Total Books -->
    <div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10 hover:border-gold-500/30 transition-colors">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-300 text-sm">Total Books</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ number_format($stats['totalBooks'] ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-maroon-700/50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>
        <span class="{{ ($stats['booksChange'] ?? 0) >= 0 ? 'text-green-400' : 'text-red-400' }} text-xs">{{ number_format($stats['booksChange'] ?? 0, 1) }}%</span>
        <span class="text-gray-400 text-xs ml-1">vs last 30 days</span>
    </div>

    <!-- Borrow Records -->
    <div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10 hover:border-gold-500/30 transition-colors">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-300 text-sm">Borrow Records</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ number_format($stats['totalBorrows'] ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-maroon-700/50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
        </div>
        <span class="{{ ($stats['borrowsChange'] ?? 0) >= 0 ? 'text-green-400' : 'text-red-400' }} text-xs">{{ number_format($stats['borrowsChange'] ?? 0, 1) }}%</span>
        <span class="text-gray-400 text-xs ml-1">vs last 30 days</span>
    </div>

    <!-- Active Borrows -->
    <div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10 hover:border-gold-500/30 transition-colors">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-300 text-sm">Active Borrows</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ number_format($stats['activeBorrows'] ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-maroon-700/50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <span class="text-gray-400 text-xs">Currently borrowed</span>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Recent Activity -->
    <div class="lg:col-span-2">
        <div class="bg-maroon-900/50 rounded-2xl border border-white/10 overflow-hidden">
            <div class="px-6 py-4 border-b border-white/10 bg-maroon-950/50">
                <h3 class="text-white font-bold text-lg">Recent Activity</h3>
            </div>

            @php($now = now())
            <div class="divide-y divide-white/10">
                @forelse($recentBorrows ?? [] as $br)
                    @php($isReturned = !is_null($br->returned_at))
                    @php($isOverdue = !$isReturned && $br->due_at?->lt($now))
                    @php($label = $isReturned ? 'Returned' : ($isOverdue ? 'Overdue' : 'Active'))
                    @php($pillClass = $isReturned ? 'bg-green-500/20 text-green-300' : ($isOverdue ? 'bg-red-500/20 text-red-300' : 'bg-amber-500/20 text-amber-300'))

                    <div class="px-6 py-4 hover:bg-maroon-800/20 transition-colors">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-white text-sm">{{ $br->user?->name ?? 'Someone' }} {{ $isReturned ? 'returned' : 'borrowed' }} "{{ $br->book?->title ?? 'a book' }}"</p>
                                <p class="text-gray-500 text-xs mt-1">{{ $br->borrowed_at?->diffForHumans() }}</p>
                            </div>
                            <span class="px-2 py-1 {{ $pillClass }} rounded text-xs">{{ $label }}</span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-400">
                        <div class="text-4xl mb-2">📭</div>
                        <p>No borrow activity yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div>
        <div class="bg-maroon-900/50 rounded-2xl border border-white/10 overflow-hidden">
            <div class="px-6 py-4 border-b border-white/10 bg-maroon-950/50">
                <h3 class="text-white font-bold text-lg">Library Overview</h3>
            </div>

            <div class="px-6 py-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-white/5">
                    <span class="text-gray-400 text-sm">Available Books</span>
                    <span class="text-white font-semibold">{{ number_format($stats['availableBooks'] ?? 0) }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-white/5">
                    <span class="text-gray-400 text-sm">Borrowed Books</span>
                    <span class="text-white font-semibold">{{ number_format($stats['borrowedBooks'] ?? 0) }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-white/5">
                    <span class="text-gray-400 text-sm">Overdue Books</span>
                    <span class="text-red-400 font-semibold">{{ number_format($stats['overdueBooks'] ?? 0) }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-400 text-sm">Students</span>
                    <span class="text-white font-semibold">{{ number_format($stats['studentCount'] ?? 0) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Users & Books -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Users -->
    <div class="bg-maroon-900/50 rounded-2xl border border-white/10 overflow-hidden">
        <div class="px-6 py-4 border-b border-white/10 bg-maroon-950/50">
            <h3 class="text-white font-bold text-lg">Recent Users</h3>
        </div>
        <div class="divide-y divide-white/10">
            @forelse($recentUsers ?? [] as $u)
                <div class="px-6 py-4 hover:bg-maroon-800/20 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-maroon-600/50 rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($u->name, 0, 2)) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-white text-sm">{{ $u->name }}</p>
                            <p class="text-gray-500 text-xs">{{ $u->email }}</p>
                        </div>
                        <span class="px-2 py-1 {{ $u->role === 'admin' ? 'bg-maroon-500/20 text-maroon-300' : ($u->role === 'librarian' ? 'bg-gold-500/20 text-gold-300' : 'bg-green-500/20 text-green-300') }} rounded text-xs">
                            {{ ucfirst($u->role) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-gray-400">
                    <p>No users yet.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Books -->
    <div class="bg-maroon-900/50 rounded-2xl border border-white/10 overflow-hidden">
        <div class="px-6 py-4 border-b border-white/10 bg-maroon-950/50">
            <h3 class="text-white font-bold text-lg">Recent Books</h3>
        </div>
        <div class="divide-y divide-white/10">
            @forelse($recentBooks ?? [] as $b)
                <div class="px-6 py-4 hover:bg-maroon-800/20 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-maroon-700/50 rounded-lg flex items-center justify-center text-gold-400 text-lg">📖</div>
                        <div class="flex-1">
                            <p class="text-white text-sm">{{ $b->title }}</p>
                            <p class="text-gray-500 text-xs">{{ $b->author }}</p>
                        </div>
                        <span class="px-2 py-1 {{ ($b->available_copies ?? 0) > 0 ? 'bg-green-500/20 text-green-300' : 'bg-amber-500/20 text-amber-300' }} rounded text-xs">
                            {{ ($b->available_copies ?? 0) > 0 ? 'Available' : 'Out of Stock' }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-gray-400">
                    <p>No books yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
