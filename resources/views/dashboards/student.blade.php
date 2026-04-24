@extends('layouts.student')
@section('title', 'Student Dashboard')
@section('content')

<div class="mb-8">
    <h2 class="text-3xl font-bold text-white">Welcome back, {{ $studentName }}! 👋</h2>
    <p class="text-gray-300 mt-1">Program: <span class="text-pink-400 font-semibold">{{ $program ?? 'Not Set' }}</span></p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <!-- Active Borrows -->
    <div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10 hover:border-pink-500/30 transition-colors">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-300 text-sm">Active Borrows</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ $stats['activeBorrowsCount'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-maroon-700/50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>
        <p class="text-gray-400 text-xs mt-1">Books currently borrowed</p>
    </div>

    <!-- Overdue Books -->
    <div class="bg-maroon-900/50 rounded-2xl p-5 border {{ ($stats['overdueCount'] ?? 0) > 0 ? 'border-red-500/30' : 'border-white/10' }} hover:border-pink-500/30 transition-colors">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-300 text-sm">Overdue Books</p>
                <h3 class="text-3xl font-bold {{ ($stats['overdueCount'] ?? 0) > 0 ? 'text-red-400' : 'text-white' }} mt-2">{{ $stats['overdueCount'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-maroon-700/50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-gray-400 text-xs mt-1">Books past due date</p>
    </div>

    <!-- Unpaid Fines -->
    <div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10 hover:border-pink-500/30 transition-colors">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-300 text-sm">Unpaid Fines</p>
                <h3 class="text-3xl font-bold text-gold-400 mt-2">₱{{ number_format($stats['unpaidFines'] ?? 0, 2) }}</h3>
            </div>
            <div class="w-12 h-12 bg-maroon-700/50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-gray-400 text-xs mt-1">Pending payment</p>
    </div>

    <!-- Total Fines -->
    <div class="bg-maroon-900/50 rounded-2xl p-5 border border-white/10 hover:border-pink-500/30 transition-colors">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-300 text-sm">Total Fines</p>
                <h3 class="text-3xl font-bold text-white mt-2">₱{{ number_format($stats['totalFines'] ?? 0, 2) }}</h3>
            </div>
            <div class="w-12 h-12 bg-maroon-700/50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
        <p class="text-gray-400 text-xs mt-1">All-time fines (paid + unpaid)</p>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Active Borrows Section -->
    <div class="lg:col-span-2">
        <div class="bg-maroon-900/50 rounded-2xl border border-white/10 overflow-hidden">
            <div class="px-6 py-4 border-b border-white/10 bg-maroon-950/50">
                <h3 class="text-white font-bold text-lg">📚 My Active Borrows</h3>
            </div>

            @forelse($activeBorrows as $borrow)
                @php($isOverdue = $borrow->due_at < now())
                <div class="px-6 py-5 border-b border-white/10 last:border-b-0 hover:bg-maroon-800/20 transition-colors">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="text-white font-semibold text-base">{{ $borrow->book->title }}</h4>
                            <p class="text-gray-400 text-sm mt-1">{{ $borrow->book->author }}</p>
                        </div>
                        <span class="inline-block px-3 py-1 {{ $isOverdue ? 'bg-red-500/20 text-red-300' : 'bg-green-500/20 text-green-300' }} rounded-lg text-xs font-semibold">
                            {{ $isOverdue ? '⚠️ OVERDUE' : '✓ On Time' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Borrowed</p>
                            <p class="text-gray-300 font-mono text-xs">{{ $borrow->borrowed_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Due Date</p>
                            <p class="text-gray-300 font-mono text-xs {{ $isOverdue ? 'text-red-400' : '' }}">{{ $borrow->due_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    @if($isOverdue)
                        @php($daysOverdue = $borrow->due_at->diffInDays(now()))
                        <div class="mt-3 p-3 bg-red-500/10 border border-red-500/20 rounded-lg">
                            <p class="text-red-300 text-sm font-semibold">Overdue by {{ $daysOverdue }} day{{ $daysOverdue > 1 ? 's' : '' }}</p>
                            <p class="text-red-300 text-xs mt-1">Fine: ₱{{ number_format($daysOverdue * 0.50, 2) }}/day at current rate</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('borrows.return', $borrow) }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-pink-600 text-white rounded-lg text-sm font-semibold hover:bg-pink-700 transition-colors">
                            Return Book
                        </button>
                    </form>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-gray-400">
                    <div class="text-4xl mb-2">📭</div>
                    <p>No active borrows. <a href="{{ route('student.books') }}" class="text-pink-400 hover:text-pink-300">Browse books to borrow.</a></p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Fines Summary Section -->
    <div>
        <div class="bg-maroon-900/50 rounded-2xl border border-white/10 overflow-hidden">
            <div class="px-6 py-4 border-b border-white/10 bg-maroon-950/50">
                <h3 class="text-white font-bold text-lg">💰 Fines Summary</h3>
            </div>

            <div class="px-6 py-6 space-y-4">
                <div class="bg-maroon-950/50 rounded-xl p-4 border border-white/5">
                    <p class="text-gray-400 text-xs mb-1">Unpaid Fines</p>
                    <p class="text-2xl font-bold text-red-400">₱{{ number_format($stats['unpaidFines'], 2) }}</p>
                </div>

                <div class="bg-maroon-950/50 rounded-xl p-4 border border-white/5">
                    <p class="text-gray-400 text-xs mb-1">Paid</p>
                    <p class="text-lg font-bold text-green-400">₱{{ number_format($stats['paidFines'], 2) }}</p>
                </div>

                @if($stats['waivedFines'] > 0)
                    <div class="bg-maroon-950/50 rounded-xl p-4 border border-white/5">
                        <p class="text-gray-400 text-xs mb-1">Waived</p>
                        <p class="text-lg font-bold text-blue-400">₱{{ number_format($stats['waivedFines'], 2) }}</p>
                    </div>
                @endif

                @if($stats['unpaidFines'] > 0)
                    <a href="{{ route('student.fines') }}" class="block w-full mt-4 px-4 py-3 bg-pink-600 text-white rounded-xl text-center font-semibold hover:bg-pink-700 transition-colors">
                        Pay Fines →
                    </a>
                @else
                    <div class="mt-4 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-center">
                        <p class="text-green-300 text-sm font-semibold">✓ No unpaid fines</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Overdue Books Alert -->
@if($overdueBorrows->count() > 0)
    <div class="mb-8 p-5 bg-red-500/10 border border-red-500/30 rounded-2xl">
        <div class="flex items-start gap-4">
            <div class="text-3xl">⚠️</div>
            <div class="flex-1">
                <h4 class="text-white font-bold text-lg">You have {{ $overdueBorrows->count() }} overdue book{{ $overdueBorrows->count() > 1 ? 's' : '' }}!</h4>
                <p class="text-red-300 text-sm mt-1">Please return them as soon as possible to avoid additional fines. Fines are charged at ₱0.50 per day per book.</p>
            </div>
        </div>
    </div>
@endif

<!-- Recent Returns Section -->
@if($returnedBorrows->count() > 0)
    <div class="bg-maroon-900/50 rounded-2xl border border-white/10 overflow-hidden">
        <div class="px-6 py-4 border-b border-white/10 bg-maroon-950/50">
            <h3 class="text-white font-bold text-lg">📖 Recent Returns</h3>
        </div>

        <div class="divide-y divide-white/10">
            @foreach($returnedBorrows as $borrow)
                <div class="px-6 py-4 hover:bg-maroon-800/20 transition-colors">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-white font-semibold">{{ $borrow->book->title }}</p>
                            <p class="text-gray-400 text-sm">{{ $borrow->book->author }}</p>
                        </div>
                        <span class="text-gray-400 text-xs">{{ $borrow->returned_at->format('M d, Y') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

@endsection
