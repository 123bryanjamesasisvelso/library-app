@extends('layouts.admin')
@section('title', 'Fine Management')
@section('content')

<div>
    @if (session('status'))
        <div class="mb-6 rounded-xl border border-green-500/20 bg-green-500/10 px-5 py-4 text-sm text-green-200">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-white font-bold text-2xl">Fine Management</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.fines.index', ['status' => '']) }}" class="px-4 py-2 {{ !$currentStatus ? 'bg-pink-600' : 'bg-white/10' }} text-white rounded-xl text-sm font-medium hover:bg-pink-700 transition-colors">All</a>
            <a href="{{ route('admin.fines.index', ['status' => 'unpaid']) }}" class="px-4 py-2 {{ $currentStatus === 'unpaid' ? 'bg-amber-600' : 'bg-white/10' }} text-white rounded-xl text-sm font-medium hover:bg-amber-700 transition-colors">Unpaid</a>
            <a href="{{ route('admin.fines.index', ['status' => 'paid']) }}" class="px-4 py-2 {{ $currentStatus === 'paid' ? 'bg-green-600' : 'bg-white/10' }} text-white rounded-xl text-sm font-medium hover:bg-green-700 transition-colors">Paid</a>
            <a href="{{ route('admin.fines.index', ['status' => 'waived']) }}" class="px-4 py-2 {{ $currentStatus === 'waived' ? 'bg-blue-600' : 'bg-white/10' }} text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition-colors">Waived</a>
        </div>
    </div>

    <div class="bg-maroon-900/50 rounded-2xl border border-white/10 overflow-hidden">
        <table class="w-full">
            <thead class="border-b border-white/10 bg-maroon-950/50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">User</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Book</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Amount</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Overdue Days</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fines as $fine)
                    <tr class="border-b border-white/10 last:border-b-0 hover:bg-maroon-800/30 transition-colors">
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-white font-medium">{{ $fine->user->name }}</p>
                                <p class="text-gray-400 text-xs">{{ $fine->user->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-white font-medium">{{ $fine->borrow->book->title }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gold-400 font-bold">₱{{ number_format($fine->amount, 2) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gray-300">{{ $fine->overdue_days }} days</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 rounded text-xs font-semibold {{ 
                                $fine->status === 'paid' ? 'bg-green-500/20 text-green-300' : 
                                ($fine->status === 'waived' ? 'bg-blue-500/20 text-blue-300' : 'bg-amber-500/20 text-amber-300')
                            }}">
                                {{ ucfirst($fine->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                @if ($fine->status === 'unpaid')
                                    <form method="POST" action="{{ route('admin.fines.mark-paid', $fine) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-green-600/20 text-green-300 rounded text-xs font-semibold hover:bg-green-600/30 transition-colors">Pay</button>
                                    </form>
                                    <button onclick="showWaiveModal({{ $fine->id }})" class="px-3 py-1 bg-blue-600/20 text-blue-300 rounded text-xs font-semibold hover:bg-blue-600/30 transition-colors">Waive</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">No fines found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($fines->hasPages())
        <div class="mt-6 px-6">
            {{ $fines->links() }}
        </div>
    @endif
</div>

<!-- Waive Modal -->
<div id="waiveModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-maroon-900 rounded-2xl border border-white/10 p-6 max-w-md w-full mx-4">
        <h3 class="text-white font-bold text-lg mb-4">Waive Fine</h3>
        <form id="waiveForm" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-gray-300 mb-2">Reason for Waiver</label>
                <textarea name="reason" required rows="3" class="w-full px-4 py-3 bg-maroon-950/60 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500"></textarea>
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeWaiveModal()" class="px-4 py-2 bg-white/10 text-white rounded-xl hover:bg-white/20 transition-colors">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">Waive</button>
            </div>
        </form>
    </div>
</div>

<script>
function showWaiveModal(fineId) {
    document.getElementById('waiveForm').action = '/admin/fines/' + fineId + '/waive';
    document.getElementById('waiveModal').classList.remove('hidden');
}

function closeWaiveModal() {
    document.getElementById('waiveModal').classList.add('hidden');
}
</script>

@endsection
