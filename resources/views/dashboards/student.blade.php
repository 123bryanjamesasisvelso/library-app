@extends('layouts.student')
@section('title', 'Student Dashboard')
@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-white">Welcome back, {{ $studentName ?? 'Student' }}!</h2>
    <p class="text-gray-400 mt-1">Program: <span class="text-pink-400 font-semibold">{{ $program ?? 'N/A' }}</span></p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-maroon-900/50 rounded-2xl p-6 border border-white/10 hover:border-pink-500/30 transition-colors">
        <p class="text-gray-400 text-sm">Active Borrows</p>
        <h3 class="text-3xl font-bold text-white mt-2">{{ number_format($stats['activeBorrows'] ?? 0) }}</h3>
    </div>
    <div class="bg-maroon-900/50 rounded-2xl p-6 border border-white/10 hover:border-pink-500/30 transition-colors">
        <p class="text-gray-400 text-sm">Overdue</p>
        <h3 class="text-3xl font-bold {{ $stats['overdue'] > 0 ? 'text-red-300' : 'text-white' }} mt-2">{{ number_format($stats['overdue'] ?? 0) }}</h3>
    </div>
    <div class="bg-maroon-900/50 rounded-2xl p-6 border border-white/10 hover:border-pink-500/30 transition-colors">
        <p class="text-gray-400 text-sm">Returned</p>
        <h3 class="text-3xl font-bold text-white mt-2">{{ number_format($stats['returned'] ?? 0) }}</h3>
    </div>
    <div class="bg-maroon-900/50 rounded-2xl p-6 border border-white/10 hover:border-pink-500/30 transition-colors">
        <p class="text-gray-400 text-sm">Fines Owed</p>
        <h3 class="text-3xl font-bold {{ $stats['finesOwed'] > 0 ? 'text-amber-300' : 'text-white' }} mt-2">${{ number_format($stats['finesOwed'] ?? 0, 2) }}</h3>
    </div>
    <div class="bg-maroon-900/50 rounded-2xl p-6 border border-white/10 hover:border-pink-500/30 transition-colors">
        <p class="text-gray-400 text-sm">Unpaid Fines</p>
        <h3 class="text-3xl font-bold {{ $stats['unpaidFines'] > 0 ? 'text-amber-300' : 'text-white' }} mt-2">${{ number_format($stats['unpaidFines'] ?? 0, 2) }}</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Active Borrows -->
    <div class="bg-maroon-900/50 rounded-2xl p-6 border border-white/10">
        <h3 class="text-lg font-bold text-white mb-4">📚 Active Borrows</h3>
        <div class="space-y-3">
            @php($now = now())
            @forelse($activeBorrows ?? [] as $borrow)
                @php($daysOverdue = $borrow->due_at?->diffInDays($now) ?? 0)
                @php($isOverdue = $borrow->due_at?->lt($now))
                <div class="bg-maroon-800/30 rounded-lg p-4 border {{ $isOverdue ? 'border-red-500/30' : 'border-white/5' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-white font-semibold">{{ $borrow->book?->title ?? 'Unknown Book' }}</p>
                            <p class="text-gray-400 text-sm">{{ $borrow->book?->author ?? 'Unknown Author' }}</p>
                            <div class="flex gap-2 mt-2">
                                <span class="inline-block px-2 py-1 {{ $isOverdue ? 'bg-red-500/20 text-red-300' : 'bg-amber-500/20 text-amber-300' }} rounded text-xs">
                                    {{ $isOverdue ? '⚠️ Overdue' : '📅 Due ' . $borrow->due_at?->format('M d') }}
                                </span>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('borrows.return', $borrow) }}">
                            @csrf
                            <button class="px-3 py-1 bg-pink-600 hover:bg-pink-700 text-white rounded text-xs font-medium transition-colors">Return</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No active borrows. Browse and borrow some books!</p>
            @endforelse
        </div>
    </div>

    <!-- Overdue Books (if any) -->
    @if (($overdueBorrows ?? []) && $overdueBorrows->count() > 0)
    <div class="bg-maroon-900/50 rounded-2xl p-6 border border-red-500/30">
        <h3 class="text-lg font-bold text-red-300 mb-4">⚠️ Overdue Books</h3>
        <div class="space-y-3">
            @foreach($overdueBorrows as $borrow)
                @php($fine = $borrow->calculateFine())
                <div class="bg-red-500/10 rounded-lg p-4 border border-red-500/30">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-white font-semibold">{{ $borrow->book?->title ?? 'Unknown Book' }}</p>
                            <p class="text-gray-400 text-sm">{{ $borrow->book?->author ?? 'Unknown Author' }}</p>
                            <div class="flex gap-2 mt-2">
                                <span class="inline-block px-2 py-1 bg-red-500/20 text-red-300 rounded text-xs font-semibold">
                                    Fine: ${{ number_format($fine, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($stats['finesOwed'] > 0)
            <div class="mt-4 p-4 bg-amber-500/10 border border-amber-500/30 rounded-lg">
                <p class="text-amber-200 text-sm font-semibold">Total Fines Due: <span class="text-lg">${{ number_format($stats['finesOwed'], 2) }}</span></p>
                <p class="text-gray-400 text-xs mt-1">Please return overdue books to clear fines.</p>
            </div>
        @endif
    </div>
    @else
    <div class="bg-maroon-900/50 rounded-2xl p-6 border border-white/10">
        <h3 class="text-lg font-bold text-white mb-4">✅ All Clear</h3>
        <p class="text-gray-400 text-sm">No overdue books. Great job keeping up!</p>
    </div>
    @endif
</div>

<!-- Borrow History -->
@if (($borrowHistory ?? []) && $borrowHistory->count() > 0)
<div class="bg-maroon-900/50 rounded-2xl p-6 border border-white/10 mb-6">
    <h3 class="text-lg font-bold text-white mb-4">📖 Recent Returns</h3>
    <div class="space-y-2">
        @foreach($borrowHistory as $borrow)
            @php($fine = $borrow->fine_amount ?? 0)
            <div class="flex items-center justify-between py-3 border-b border-white/5 last:border-b-0">
                <div class="flex-1">
                    <p class="text-white text-sm">{{ $borrow->book?->title ?? 'Unknown Book' }}</p>
                    <p class="text-gray-500 text-xs">Returned {{ $borrow->returned_at?->diffForHumans() }}</p>
                </div>
                <div class="text-right flex gap-2 items-center">
                    @if ($fine > 0)
                        @if ($borrow->fine_paid)
                            <span class="inline-block px-2 py-1 bg-green-500/20 text-green-300 rounded text-xs font-medium">
                                ✓ Paid
                            </span>
                        @else
                            <span class="inline-block px-2 py-1 bg-amber-500/20 text-amber-300 rounded text-xs font-medium">
                                Fine: ${{ number_format($fine, 2) }}
                            </span>
                            <form method="POST" action="{{ route('borrows.pay-fine', $borrow) }}">
                                @csrf
                                <button class="px-2 py-1 bg-pink-600 hover:bg-pink-700 text-white rounded text-xs font-medium transition-colors">
                                    Pay
                                </button>
                            </form>
                        @endif
                    @else
                        <span class="text-gray-400 text-xs">No fine</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<div class="mt-6 flex gap-4">
    <a href="{{ route('student.books') }}" class="px-6 py-3 bg-pink-600 hover:bg-pink-700 text-white rounded-xl font-medium transition-colors">
        📚 Browse Books
    </a>
    <a href="{{ url('/') }}" class="px-6 py-3 bg-maroon-900/50 hover:bg-maroon-800/50 text-white rounded-xl font-medium border border-white/10 transition-colors">
        ← Back Home
    </a>
</div>
@endsection
