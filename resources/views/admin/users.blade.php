@extends('layouts.admin')
@section('title', 'User Management')
@section('header', '👥 User Management')
@section('content')
@if (session('status'))
    <div class="mb-6 rounded-xl border border-green-500/20 bg-green-500/10 px-5 py-4 text-sm text-green-200 flex items-center gap-2">
        <span>✓</span> {{ session('status') }}
    </div>
@endif
@if ($errors->any())
    <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 px-5 py-4 text-sm text-red-200 flex items-center gap-2">
        <span>⚠️</span> {{ $errors->first() }}
    </div>
@endif

<div class="mb-8">
    <h2 class="text-lg font-bold text-white mb-4">🔍 Find Users</h2>
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-3">
        <input type="text" name="q" value="{{ $q ?? request('q') }}" placeholder="Search by name or email…"
            class="flex-1 pl-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-maroon-500 transition-all">
        <button type="submit" class="px-6 py-3 bg-maroon-600 hover:bg-maroon-700 text-white rounded-xl font-medium transition-colors">
            Search
        </button>
    </form>
</div>
<div class="bg-library-card rounded-2xl border border-white/10 overflow-hidden shadow-lg">
<div class="overflow-x-auto">
<table class="w-full text-sm">
    <thead class="bg-maroon-900/50 border-b border-white/10">
        <tr class="text-gray-300">
            <th class="text-left px-6 py-4 font-semibold">👤 User</th>
            <th class="px-6 py-4 font-semibold">Role</th>
            <th class="px-6 py-4 font-semibold">📚 Program</th>
            <th class="px-6 py-4 font-semibold">Borrowed</th>
            <th class="px-6 py-4 font-semibold">📅 Joined</th>
            <th class="text-right px-6 py-4 font-semibold">⚙️ Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
            <td class="px-6 py-4 text-white">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-maroon-500/20 rounded-full flex items-center justify-center text-maroon-300 font-bold text-sm">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-medium">{{ $user->name }}</p>
                        <p class="text-gray-400 text-xs">{{ $user->email }}</p>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4">
                <span class="inline-flex items-center gap-1 px-3 py-1 {{ $user->role === 'admin' ? 'bg-red-500/20 text-red-300' : 'bg-blue-500/20 text-blue-300' }} rounded-lg text-xs font-semibold">
                    {{ $user->role === 'admin' ? '👑' : '🧑' }} {{ ucfirst($user->role) }}
                </span>
            </td>
            <td class="px-6 py-4">
                @if ($user->program)
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-purple-500/20 text-purple-300 rounded-lg text-xs font-medium">
                        {{ strtoupper($user->program) }}
                    </span>
                @else
                    <span class="text-gray-500 text-xs">—</span>
                @endif
            </td>
            <td class="px-6 py-4 text-gray-300">
                <span class="px-2 py-1 bg-amber-500/10 text-amber-300 rounded text-xs font-medium">{{ $user->borrows_count }}</span>
            </td>
            <td class="px-6 py-4 text-gray-400 text-xs">{{ $user->created_at?->format('M d, Y') }}</td>
            <td class="px-6 py-4 text-right space-x-2">
                <a href="{{ route('admin.users.show', $user) }}" class="inline-block px-3 py-2 bg-blue-500/20 text-blue-300 hover:bg-blue-500/30 rounded-lg text-xs font-medium transition-colors">
                    👁️ View
                </a>
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-2 bg-red-500/20 text-red-300 hover:bg-red-500/30 rounded-lg text-xs font-medium transition-colors">
                        🗑️ Remove
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                <div class="text-4xl mb-2">📭</div>
                <p>No users found. Start by registering new users!</p>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
</div>

<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection
