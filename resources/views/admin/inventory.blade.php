@extends('layouts.admin')
@section('title', 'Inventory Management')
@section('header', '📦 Inventory by Department')
@section('content')

<div class="mb-8">
    <h2 class="text-lg font-bold text-white mb-4">📊 System Overview</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-maroon-600/20 to-maroon-600/5 rounded-2xl p-6 border border-maroon-500/20 hover:border-maroon-500/40 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-300 text-sm">🏢 Departments</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $stats['totalDepartments'] }}</h3>
                </div>
                <div class="text-4xl opacity-30">🏢</div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-600/20 to-blue-600/5 rounded-2xl p-6 border border-blue-500/20 hover:border-blue-500/40 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-300 text-sm">📚 Total Books</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ number_format($stats['totalBooks']) }}</h3>
                </div>
                <div class="text-4xl opacity-30">📚</div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-600/20 to-green-600/5 rounded-2xl p-6 border border-green-500/20 hover:border-green-500/40 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-300 text-sm">✓ Available</p>
                    <h3 class="text-3xl font-bold text-green-300 mt-2">{{ number_format($stats['totalAvailable']) }}</h3>
                </div>
                <div class="text-4xl opacity-30">✓</div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-amber-600/20 to-amber-600/5 rounded-2xl p-6 border border-amber-500/20 hover:border-amber-500/40 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-300 text-sm">📤 Borrowed</p>
                    <h3 class="text-3xl font-bold text-amber-300 mt-2">{{ number_format($stats['totalBorrowed']) }}</h3>
                </div>
                <div class="text-4xl opacity-30">📤</div>
            </div>
        </div>
    </div>
</div>

<div class="space-y-6">
    @forelse($departments as $department)
    <div class="bg-library-card rounded-2xl p-6 border border-white/10 hover:border-maroon-500/30 transition-colors shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="text-3xl">🏢</div>
                <div>
                    <h4 class="text-lg font-bold text-white">{{ $department->name }}</h4>
                    <p class="text-gray-400 text-sm">Code: <span class="font-mono font-semibold">{{ $department->code }}</span></p>
                </div>
            </div>
            <div class="text-right bg-white/5 px-4 py-3 rounded-xl border border-white/10">
                <p class="text-gray-300 text-sm">📚 {{ $department->books->count() }} books</p>
                <p class="text-amber-300 text-xs font-semibold mt-1">📤 {{ $department->books->sum(fn ($b) => $b->active_borrows) }} borrowed</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/10 bg-white/5">
                        <th class="text-left px-4 py-3 text-gray-400 font-semibold">📖 Title & Author</th>
                        <th class="px-4 py-3 text-gray-400 font-semibold">ISBN</th>
                        <th class="px-4 py-3 text-gray-400 font-semibold text-center">✓ Available</th>
                        <th class="px-4 py-3 text-gray-400 font-semibold text-center">📤 Borrowed</th>
                        <th class="px-4 py-3 text-gray-400 font-semibold text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($department->books as $book)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                        <td class="px-4 py-3 text-white">
                            <div class="flex items-start gap-2">
                                <span class="text-lg">📚</span>
                                <div>
                                    <p class="font-semibold">{{ $book->title }}</p>
                                    <p class="text-gray-400 text-xs">{{ $book->author }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-400 font-mono text-xs">{{ $book->isbn }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-block px-3 py-1 bg-green-500/20 text-green-300 rounded-lg text-xs font-bold">
                                ✓ {{ $book->available_copies }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-block px-3 py-1 {{ $book->active_borrows > 0 ? 'bg-amber-500/20 text-amber-300' : 'bg-white/10 text-gray-400' }} rounded-lg text-xs font-medium">
                                {{ $book->active_borrows > 0 ? '📤 ' . $book->active_borrows : '—' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-gray-300 font-semibold">{{ $book->total_copies }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500 text-sm">
                            <div class="text-2xl mb-1">📭</div>
                            No books in this department yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <div class="bg-library-card rounded-2xl p-12 border border-white/10 text-center">
        <div class="text-5xl mb-3">📭</div>
        <p class="text-gray-400 text-lg">No departments created yet.</p>
        <p class="text-gray-500 text-sm mt-2">Start by adding departments and books through the Books management panel.</p>
    </div>
    @endforelse
</div>

@endsection
