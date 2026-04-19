@extends('layouts.admin')
@section('title', 'Admin Profile')
@section('header', 'Profile Settings')
@section('content')
<div class="bg-library-card rounded-2xl p-8 border border-white/5 mb-6">
<div class="flex items-center gap-6 mb-6"><div class="w-20 h-20 bg-maroon-500 rounded-2xl flex items-center justify-center text-white text-2xl font-bold">{{ strtoupper(substr($user->name ?? 'A',0,1)) }}</div><div><h2 class="text-2xl font-bold text-white">{{ $user->name ?? 'Admin' }}</h2><p class="text-gray-400">{{ $user->email ?? '' }}</p><div class="flex gap-4 mt-2"><span class="px-3 py-1 bg-maroon-500/20 text-maroon-300 rounded-lg text-xs font-medium">{{ ucfirst($user->role ?? 'admin') }}</span><span class="text-gray-500 text-xs">Member since {{ $user->created_at?->format('M Y') }}</span></div></div></div>
</div>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
<div class="bg-library-card rounded-2xl p-5 border border-white/5"><p class="text-gray-400 text-sm">Books Borrowed</p><h3 class="text-2xl font-bold text-white mt-1">{{ $stats['total'] ?? 0 }}</h3></div>
<div class="bg-library-card rounded-2xl p-5 border border-white/5"><p class="text-gray-400 text-sm">Currently Borrowed</p><h3 class="text-2xl font-bold text-white mt-1">{{ $stats['currently'] ?? 0 }}</h3></div>
<div class="bg-library-card rounded-2xl p-5 border border-white/5"><p class="text-gray-400 text-sm">Overdue</p><h3 class="text-2xl font-bold text-red-300 mt-1">{{ $stats['overdue'] ?? 0 }}</h3></div>
<div class="bg-library-card rounded-2xl p-5 border border-white/5"><p class="text-gray-400 text-sm">Returned</p><h3 class="text-2xl font-bold text-green-300 mt-1">{{ $stats['returned'] ?? 0 }}</h3></div>
</div>
<div class="bg-library-card rounded-2xl p-6 border border-white/5">
<h3 class="text-lg font-bold text-white mb-4">Borrowing History</h3>
@if (($borrows ?? collect())->isEmpty())
    <div class="text-center py-12"><p class="text-gray-500">No borrowing history yet.</p><p class="text-gray-600 text-sm mt-2">Start borrowing books to see your history here.</p></div>
@else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-white/10 text-gray-400"><th class="text-left py-3">Book</th><th class="py-3">Due</th><th class="py-3">Returned</th><th class="py-3">Status</th></tr></thead>
            <tbody>
                @foreach ($borrows as $b)
                    <tr class="border-b border-white/5">
                        <td class="py-3 text-white">{{ $b->book?->title ?? '—' }}<div class="text-xs text-gray-500">{{ $b->book?->author ?? '' }}</div></td>
                        <td class="py-3 text-gray-300 text-center">{{ $b->due_at?->format('M d, Y') }}</td>
                        <td class="py-3 text-gray-400 text-center">{{ $b->returned_at?->format('M d, Y') ?? '—' }}</td>
                        <td class="py-3 text-center">
                            <span class="px-2 py-1 rounded text-xs {{ $b->status === 'returned' ? 'bg-green-500/20 text-green-300' : ($b->status === 'overdue' ? 'bg-red-500/20 text-red-300' : 'bg-amber-500/20 text-amber-300') }}">{{ ucfirst($b->status) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
</div>
@endsection
