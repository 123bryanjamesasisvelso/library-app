@extends('layouts.student')
@section('title', 'My Fines')
@section('content')

<div class="max-w-4xl">
    @if (session('status'))
        <div class="mb-6 rounded-xl border border-green-500/20 bg-green-500/10 px-5 py-4 text-sm text-green-200">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-maroon-900/50 rounded-2xl p-6 border border-white/10 mb-6">
        <h2 class="text-white font-bold text-xl mb-2">My Outstanding Fines</h2>
        <p class="text-gray-400 text-sm mb-4">Fines are calculated for books returned after their due date at ₱0.50 per day.</p>
        
        <div class="bg-maroon-950/50 rounded-xl p-4 border border-white/5">
            <div class="text-3xl font-bold text-gold-400">₱{{ number_format($totalUnpaid, 2) }}</div>
            <div class="text-gray-400 text-sm mt-1">Total Unpaid Fines</div>
        </div>
    </div>

    <div class="bg-maroon-900/50 rounded-2xl border border-white/10 overflow-hidden">
        <div class="px-6 py-4 border-b border-white/10">
            <h3 class="text-white font-bold">Fine History</h3>
        </div>

        @forelse($fines as $fine)
            <div class="px-6 py-4 border-b border-white/10 last:border-b-0 hover:bg-maroon-800/30 transition-colors">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <div>
                        <p class="text-white font-semibold">{{ $fine->borrow->book->title }}</p>
                        <p class="text-gray-400 text-sm mt-1">{{ $fine->borrow->book->author }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gold-400 font-bold text-lg">₱{{ number_format($fine->amount, 2) }}</p>
                        <p class="text-gray-400 text-xs mt-1">{{ $fine->overdue_days }} days overdue</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                    <div>
                        <span class="text-gray-500">Calculated:</span>
                        <span class="text-gray-300 ml-2">{{ $fine->calculated_at->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Due Date:</span>
                        <span class="text-gray-300 ml-2">{{ $fine->borrow->due_at->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="inline-block px-3 py-1 rounded text-xs font-semibold {{ 
                            $fine->status === 'paid' ? 'bg-green-500/20 text-green-300' : 
                            ($fine->status === 'waived' ? 'bg-blue-500/20 text-blue-300' : 'bg-amber-500/20 text-amber-300')
                        }}">
                            {{ ucfirst($fine->status) }}
                        </span>
                    </div>
                </div>

                @if ($fine->status === 'unpaid')
                    <div class="mt-3 pt-3 border-t border-white/5">
                        <form method="POST" action="{{ route('admin.fines.mark-paid', $fine) }}" class="inline">
                            @csrf
                            <input type="hidden" name="notes" value="Self payment">
                            <button type="submit" class="px-4 py-2 bg-green-600/20 text-green-300 rounded-lg text-xs font-semibold hover:bg-green-600/30 transition-colors">
                                Mark as Paid
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @empty
            <div class="px-6 py-12 text-center text-gray-400">
                <div class="text-4xl mb-2">✨</div>
                <p>No fines! Keep returning books on time.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection
