@extends('layouts.admin')
@section('title', 'Library Dashboard')
@section('header', 'Library Dashboard')
@section('content')
<div class="mb-8"><h2 class="text-2xl font-bold text-white">Good morning, {{ $adminName ?? 'Admin' }}!</h2><p class="text-gray-400 mt-1">Here's your library overview for today.</p></div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
<div class="bg-library-card rounded-2xl p-6 border border-white/5"><p class="text-gray-400 text-sm">Total Books</p><h3 class="text-3xl font-bold text-white mt-1">{{ number_format($stats['totalBooks'] ?? 0) }}</h3><span class="{{ ($stats['totalBooksChange'] ?? 0) >= 0 ? 'text-green-400' : 'text-red-400' }} text-xs">{{ number_format($stats['totalBooksChange'] ?? 0, 1) }}% from last month</span></div>
<div class="bg-library-card rounded-2xl p-6 border border-white/5"><p class="text-gray-400 text-sm">Available</p><h3 class="text-3xl font-bold text-white mt-1">{{ number_format($stats['availableBooks'] ?? 0) }}</h3><span class="text-gray-400 text-xs">Live count</span></div>
<div class="bg-library-card rounded-2xl p-6 border border-white/5"><p class="text-gray-400 text-sm">Borrowed</p><h3 class="text-3xl font-bold text-white mt-1">{{ number_format($stats['borrowedBooks'] ?? 0) }}</h3><span class="text-gray-400 text-xs">Live count</span></div>
<div class="bg-library-card rounded-2xl p-6 border border-white/5"><p class="text-gray-400 text-sm">Overdue</p><h3 class="text-3xl font-bold text-white mt-1">{{ number_format($stats['overdueBooks'] ?? 0) }}</h3><span class="{{ ($stats['overdueChange'] ?? 0) >= 0 ? 'text-red-400' : 'text-green-400' }} text-xs">{{ number_format($stats['overdueChange'] ?? 0, 1) }}% from last month</span></div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
<div class="bg-library-card rounded-2xl p-6 border border-white/5">
<h3 class="text-lg font-bold text-white mb-4">Recent Activity</h3>
<div class="space-y-3">
@forelse($recentActivity ?? [] as $a)
<div class="flex justify-between py-2 border-b border-white/5">
    <div>
        <p class="text-white text-sm">{{ $a['text'] }}</p>
        <p class="text-gray-500 text-xs">{{ \Illuminate\Support\Carbon::parse($a['at'])->diffForHumans() }}</p>
    </div>
    <span class="{{ $a['status'] === 'returned' ? 'text-green-400' : ($a['status'] === 'overdue' ? 'text-red-400' : 'text-amber-400') }} text-xs">{{ $a['statusLabel'] }}</span>
</div>
@empty
<p class="text-gray-500 text-sm">No recent activity.</p>
@endforelse
</div></div>
<div class="bg-library-card rounded-2xl p-6 border border-white/5">
<h3 class="text-lg font-bold text-white mb-4">Popular Books</h3>
<div class="space-y-3">
@forelse($popularBooks ?? [] as $p)
<div class="flex justify-between items-center py-2 border-b border-white/5">
    <div><p class="text-white text-sm">{{ $p->title }}</p><p class="text-gray-500 text-xs">{{ $p->author }}</p></div>
    <span class="text-gray-400 text-xs">{{ $p->borrows_count }} borrows</span>
</div>
@empty
<p class="text-gray-500 text-sm">No data yet.</p>
@endforelse
</div></div>
</div>
@endsection
