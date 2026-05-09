@extends('layouts.admin')
@section('title', 'Admin Profile')
@section('header', '👤 Profile Settings')
@section('content')

<div class="bg-gradient-to-br from-maroon-600/20 to-maroon-600/5 rounded-2xl p-8 border border-maroon-500/20 mb-8 shadow-lg">
    <div class="flex items-center gap-6">
        <div class="w-24 h-24 bg-gradient-to-br from-maroon-500 to-maroon-700 rounded-2xl flex items-center justify-center text-white text-3xl font-bold shadow-lg">
            {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
        </div>
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-1">
                <span class="text-2xl">👤</span>
                <h2 class="text-2xl font-bold text-white">{{ $user->name ?? 'Admin' }}</h2>
            </div>
            <div class="flex items-center gap-2 mb-3">
                <span class="text-lg">📧</span>
                <p class="text-gray-300">{{ $user->email ?? '' }}</p>
            </div>
            <div class="flex gap-3 flex-wrap">
                <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-500/20 text-red-300 rounded-lg text-xs font-bold">
                    👑 {{ ucfirst($user->role ?? 'admin') }}
                </span>
                <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-500/20 text-blue-300 rounded-lg text-xs">
                    📚 Part of DigiLib since {{ $user->created_at?->format('M Y') ?? 'May 2026' }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-gradient-to-br from-purple-600/20 to-purple-600/5 rounded-2xl p-6 border border-purple-500/20 hover:border-purple-500/40 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-300 text-sm">📖 Borrowed</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ $stats['total'] ?? 0 }}</h3>
            </div>
            <div class="text-4xl opacity-20">📖</div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-amber-600/20 to-amber-600/5 rounded-2xl p-6 border border-amber-500/20 hover:border-amber-500/40 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-300 text-sm">📌 Currently Borrowed</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ $stats['currently'] ?? 0 }}</h3>
            </div>
            <div class="text-4xl opacity-20">📌</div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-red-600/20 to-red-600/5 rounded-2xl p-6 border border-red-500/20 hover:border-red-500/40 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-300 text-sm">⏰ Overdue</p>
                <h3 class="text-3xl font-bold text-red-300 mt-2">{{ $stats['overdue'] ?? 0 }}</h3>
            </div>
            <div class="text-4xl opacity-20">⏰</div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-green-600/20 to-green-600/5 rounded-2xl p-6 border border-green-500/20 hover:border-green-500/40 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-300 text-sm">✅ Returned</p>
                <h3 class="text-3xl font-bold text-green-300 mt-2">{{ $stats['returned'] ?? 0 }}</h3>
            </div>
            <div class="text-4xl opacity-20">✅</div>
        </div>
    </div>
</div>

<div class="bg-library-card rounded-2xl p-8 border border-white/10 shadow-lg">
    <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
        <span class="text-2xl">📚</span> Borrowing History
    </h3>
    @if (($borrows ?? collect())->isEmpty())
        <div class="text-center py-16">
            <div class="text-5xl mb-4 opacity-30">✨</div>
            <p class="text-gray-400 text-lg">✨ No history yet — start borrowing books to build your reading journey!</p>
            <p class="text-gray-500 text-sm mt-3">Head over to the Books section to begin exploring.</p>
            <a href="{{ route('admin.books.index') }}" class="inline-block mt-6 px-6 py-3 bg-maroon-600 hover:bg-maroon-700 text-white rounded-xl font-medium transition-colors">
                📚 Browse Books
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/10 bg-white/5">
                        <th class="text-left px-4 py-4 text-gray-400 font-semibold">📖 Book</th>
                        <th class="px-4 py-4 text-gray-400 font-semibold text-center">Due Date</th>
                        <th class="px-4 py-4 text-gray-400 font-semibold text-center">Returned</th>
                        <th class="px-4 py-4 text-gray-400 font-semibold text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($borrows as $b)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                            <td class="px-4 py-4 text-white">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">📚</span>
                                    <div>
                                        <p class="font-medium">{{ $b->book?->title ?? '—' }}</p>
                                        <p class="text-gray-400 text-xs">{{ $b->book?->author ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-gray-300 text-center">{{ $b->due_at?->format('M d, Y') }}</td>
                            <td class="px-4 py-4 text-gray-400 text-center">{{ $b->returned_at?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-4 text-center">
                                <span class="inline-block px-3 py-1 rounded-lg text-xs font-semibold {{ $b->status === 'returned' ? 'bg-green-500/20 text-green-300' : ($b->status === 'overdue' ? 'bg-red-500/20 text-red-300' : 'bg-amber-500/20 text-amber-300') }}">
                                    {{ $b->status === 'returned' ? '✓ Returned' : ($b->status === 'overdue' ? '⚠️ Overdue' : '📌 Active') }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
