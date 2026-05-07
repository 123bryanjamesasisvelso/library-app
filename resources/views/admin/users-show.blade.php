@extends('layouts.admin')
@section('title', 'User Details')
@section('header', 'User Details')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 bg-library-card rounded-2xl border border-white/5 p-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-maroon-500/30 rounded-2xl flex items-center justify-center text-white text-xl font-bold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-white font-bold text-lg">{{ $user->name }}</p>
                <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                <p class="text-gray-500 text-xs mt-1">Joined {{ $user->created_at?->format('M d, Y') }}</p>
            </div>
        </div>
        <div class="mt-5">
            <span class="px-3 py-1 rounded-lg text-xs font-medium {{ $user->role === 'admin' ? 'bg-maroon-500/20 text-maroon-300' : ($user->role === 'librarian' ? 'bg-amber-500/20 text-amber-300' : 'bg-green-500/20 text-green-300') }}">
                {{ ucfirst($user->role) }}
            </span>
        </div>
        <div class="mt-6 text-sm text-gray-300">
            <p><span class="text-gray-500">Total borrows:</span> {{ $user->borrows->count() }}</p>
            <p class="mt-1"><span class="text-gray-500">Active:</span> {{ $user->borrows->whereNull('returned_at')->count() }}</p>
        </div>
        <div class="mt-6">
            <a href="{{ route('admin.users.index') }}" class="inline-block px-5 py-3 bg-white/5 text-gray-200 rounded-xl hover:bg-white/10 transition-colors">Back</a>
        </div>
    </div>

    <div class="lg:col-span-2 bg-library-card rounded-2xl border border-white/5 p-6">
        <h3 class="text-white font-bold mb-4">Borrowing History</h3>
        @if ($user->borrows->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500">No borrowing history yet.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/10 text-gray-400">
                            <th class="text-left py-3">Book</th>
                            <th class="py-3">Due</th>
                            <th class="py-3">Returned</th>
                            <th class="py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->borrows->sortByDesc('borrowed_at') as $b)
                            <tr class="border-b border-white/5">
                                <td class="py-3 text-white">
                                    {{ $b->book?->title ?? '—' }}
                                    <div class="text-xs text-gray-500">{{ $b->book?->author ?? '' }}</div>
                                </td>
                                <td class="py-3 text-gray-300 text-center">{{ $b->due_at?->format('M d, Y') }}</td>
                                <td class="py-3 text-gray-400 text-center">{{ $b->returned_at?->format('M d, Y') ?? '—' }}</td>
                                <td class="py-3 text-center">
                                    <span class="px-2 py-1 rounded text-xs
                                        {{ $b->status === 'returned' ? 'bg-green-500/20 text-green-300' : ($b->status === 'overdue' ? 'bg-red-500/20 text-red-300' : 'bg-amber-500/20 text-amber-300') }}">
                                        {{ ucfirst($b->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

