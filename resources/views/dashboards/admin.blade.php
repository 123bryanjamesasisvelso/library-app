@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('header', 'Dashboard')
@section('content')
<div class="mb-8"><h2 class="text-2xl font-bold text-white">Welcome back, {{ $adminName ?? 'Admin' }}!</h2><p class="text-gray-400 mt-1">Here's what's happening in your library today.</p></div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
<div class="bg-library-card rounded-2xl p-6 border border-white/5"><p class="text-gray-400 text-sm">Total Users</p><h3 class="text-3xl font-bold text-white mt-2">{{ number_format($stats['totalUsers'] ?? 0) }}</h3><span class="{{ ($stats['usersChange'] ?? 0) >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm">{{ number_format($stats['usersChange'] ?? 0, 1) }}%</span></div>
<div class="bg-library-card rounded-2xl p-6 border border-white/5"><p class="text-gray-400 text-sm">Total Books</p><h3 class="text-3xl font-bold text-white mt-2">{{ number_format($stats['totalBooks'] ?? 0) }}</h3><span class="{{ ($stats['booksChange'] ?? 0) >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm">{{ number_format($stats['booksChange'] ?? 0, 1) }}%</span></div>
<div class="bg-library-card rounded-2xl p-6 border border-white/5"><p class="text-gray-400 text-sm">Borrow Records</p><h3 class="text-3xl font-bold text-white mt-2">{{ number_format($stats['totalBorrows'] ?? 0) }}</h3><span class="{{ ($stats['borrowsChange'] ?? 0) >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm">{{ number_format($stats['borrowsChange'] ?? 0, 1) }}%</span></div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
<div class="bg-library-card rounded-2xl p-6 border border-white/5">
<h3 class="text-lg font-bold text-white mb-4">Recent Users</h3>
<div class="space-y-3">
@forelse($recentUsers ?? [] as $u)
<div class="flex items-center gap-3">
    <div class="w-9 h-9 bg-blue-500/20 rounded-full flex items-center justify-center text-blue-300 text-sm font-bold">{{ strtoupper(substr($u->name, 0, 2)) }}</div>
    <div class="flex-1"><p class="text-white text-sm">{{ $u->name }}</p><p class="text-gray-500 text-xs">{{ $u->email }}</p></div>
    <span class="px-2 py-1 {{ $u->role === 'admin' ? 'bg-maroon-500/20 text-maroon-300' : ($u->role === 'librarian' ? 'bg-amber-500/20 text-amber-300' : 'bg-green-500/20 text-green-300') }} rounded text-xs">{{ ucfirst($u->role) }}</span>
</div>
@empty
<p class="text-gray-500 text-sm">No users yet.</p>
@endforelse
</div>
</div>
<div class="bg-library-card rounded-2xl p-6 border border-white/5">
<h3 class="text-lg font-bold text-white mb-4">Recent Books</h3>
<div class="space-y-3">
@forelse($recentBooks ?? [] as $b)
<div class="flex items-center gap-3">
    <div class="w-9 h-9 bg-purple-500/20 rounded-lg flex items-center justify-center text-purple-300 text-sm">📖</div>
    <div class="flex-1"><p class="text-white text-sm">{{ $b->title }}</p><p class="text-gray-500 text-xs">{{ $b->author }}</p></div>
    <span class="px-2 py-1 {{ ($b->available_copies ?? 0) > 0 ? 'bg-green-500/20 text-green-300' : 'bg-amber-500/20 text-amber-300' }} rounded text-xs">{{ ($b->available_copies ?? 0) > 0 ? 'Available' : 'Unavailable' }}</span>
</div>
@empty
<p class="text-gray-500 text-sm">No books yet.</p>
@endforelse
</div>
</div>
</div>
<div class="mt-6 bg-library-card rounded-2xl p-6 border border-white/5">
<h3 class="text-lg font-bold text-white mb-4">Borrow Activity</h3>
<div class="space-y-3">
@php($now = now())
@forelse($recentBorrows ?? [] as $br)
@php($isReturned = !is_null($br->returned_at))
@php($isOverdue = !$isReturned && $br->due_at?->lt($now))
@php($label = $isReturned ? 'Returned' : ($isOverdue ? 'Overdue' : 'Active'))
@php($pill = $isReturned ? 'bg-green-500/20 text-green-300' : ($isOverdue ? 'bg-red-500/20 text-red-300' : 'bg-amber-500/20 text-amber-300'))
<div class="flex items-center justify-between py-2 border-b border-white/5">
    <div>
        <p class="text-white text-sm">{{ $br->user?->name ?? 'Someone' }} {{ $isReturned ? 'returned' : 'borrowed' }} "{{ $br->book?->title ?? 'a book' }}"</p>
        <p class="text-gray-500 text-xs">{{ $br->borrowed_at?->diffForHumans() }}</p>
    </div>
    <span class="px-2 py-1 {{ $pill }} rounded text-xs">{{ $label }}</span>
</div>
@empty
<p class="text-gray-500 text-sm">No borrow activity yet.</p>
@endforelse
</div>
</div>
</div>
@endsection
