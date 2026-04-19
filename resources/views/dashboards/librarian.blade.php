@extends('layouts.librarian')
@section('title', 'Librarian Dashboard')
@section('content')
<div class="mb-8"><h2 class="text-2xl font-bold text-white">Good morning, {{ $name ?? 'Librarian' }}!</h2><p class="text-gray-300 mt-1">Here's your library overview for today.</p></div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
<div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10"><p class="text-gray-300 text-sm">Total Books</p><h3 class="text-2xl font-bold text-white mt-1">{{ number_format($stats['total'] ?? 0) }}</h3><span class="text-gray-300 text-xs">Live</span></div>
<div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10"><p class="text-gray-300 text-sm">Available</p><h3 class="text-2xl font-bold text-white mt-1">{{ number_format($stats['available'] ?? 0) }}</h3><span class="text-gray-300 text-xs">Live</span></div>
<div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10"><p class="text-gray-300 text-sm">Borrowed</p><h3 class="text-2xl font-bold text-white mt-1">{{ number_format($stats['borrowed'] ?? 0) }}</h3><span class="text-gray-300 text-xs">Live</span></div>
<div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10"><p class="text-gray-300 text-sm">Overdue</p><h3 class="text-2xl font-bold text-white mt-1">{{ number_format($stats['overdue'] ?? 0) }}</h3><span class="text-gray-300 text-xs">Live</span></div>
<div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10"><p class="text-gray-300 text-sm">My Borrowed</p><h3 class="text-2xl font-bold text-white mt-1">{{ number_format($stats['myBorrowed'] ?? 0) }}</h3></div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
<div class="bg-maroon-900/50 rounded-2xl p-6 border border-white/10">
<h3 class="text-lg font-bold text-white mb-4">Recent Activity</h3>
<div class="space-y-3">
@php($now = now())
@forelse($recentActivity ?? [] as $a)
@php($returned = !is_null($a->returned_at))
@php($overdue = !$returned && $a->due_at?->lt($now))
@php($label = $returned ? 'Returned' : ($overdue ? 'Overdue' : 'Active'))
<div class="flex justify-between py-2 border-b border-white/5">
    <div>
        <p class="text-white text-sm">{{ $a->user?->name ?? 'Someone' }} {{ $returned ? 'returned' : 'borrowed' }} "{{ $a->book?->title ?? 'a book' }}"</p>
        <p class="text-gray-400 text-xs">{{ $a->borrowed_at?->diffForHumans() }}</p>
    </div>
    <span class="{{ $returned ? 'text-green-400' : ($overdue ? 'text-red-400' : 'text-amber-400') }} text-xs">{{ $label }}</span>
</div>
@empty
<p class="text-gray-400 text-sm">No activity yet.</p>
@endforelse
</div></div>
<div class="bg-maroon-900/50 rounded-2xl p-6 border border-white/10">
<h3 class="text-lg font-bold text-white mb-4">Popular Books</h3>
<div class="space-y-3">
@forelse($popularBooks ?? [] as $p)
<div class="flex justify-between items-center py-2 border-b border-white/5">
    <div><p class="text-white text-sm">{{ $p->title }}</p><p class="text-gray-400 text-xs">{{ $p->author }}</p></div>
    <span class="text-gray-300 text-xs">{{ $p->borrows_count }} borrows</span>
</div>
@empty
<p class="text-gray-400 text-sm">No data yet.</p>
@endforelse
</div></div>
</div>
@endsection
