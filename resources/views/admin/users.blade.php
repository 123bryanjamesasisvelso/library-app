@extends('layouts.admin')
@section('title', 'User Management')
@section('header', 'User Management')
@section('content')
@if (session('status'))
    <div class="mb-6 rounded-xl border border-white/10 bg-library-card px-5 py-4 text-sm text-gray-200">
        {{ session('status') }}
    </div>
@endif
@if ($errors->any())
    <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 px-5 py-4 text-sm text-red-200">
        {{ $errors->first() }}
    </div>
@endif

<form method="GET" action="{{ route('admin.users.index') }}" class="mb-6">
    <input type="text" name="q" value="{{ $q ?? request('q') }}" placeholder="Search by name or email..."
        class="w-full max-w-md pl-4 py-3 bg-library-card border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-maroon-500">
</form>
<div class="bg-library-card rounded-2xl border border-white/5 overflow-hidden">
<table class="w-full text-sm"><thead><tr class="border-b border-white/10 text-gray-400"><th class="text-left px-6 py-4">User</th><th class="px-6 py-4">Role</th><th class="px-6 py-4">Borrowed</th><th class="px-6 py-4">Joined</th><th class="text-right px-6 py-4">Actions</th></tr></thead>
<tbody>
@forelse($users as $user)
<tr class="border-b border-white/5 hover:bg-library-hover">
<td class="px-6 py-4 text-white">{{ $user->name }}<br><span class="text-gray-500 text-xs">{{ $user->email }}</span></td>
<td class="px-6 py-4">
    <span class="px-2 py-1 {{ $user->role === 'admin' ? 'bg-maroon-500/20 text-maroon-300' : ($user->role === 'librarian' ? 'bg-amber-500/20 text-amber-300' : 'bg-green-500/20 text-green-300') }} rounded text-xs">
        {{ ucfirst($user->role) }}
    </span>
</td>
<td class="px-6 py-4 text-gray-300">{{ $user->borrows_count }}</td>
<td class="px-6 py-4 text-gray-400">{{ $user->created_at?->format('M d, Y') }}</td>
<td class="px-6 py-4 text-right space-x-2">
    <a href="{{ route('admin.users.show', $user) }}" class="inline-block px-3 py-1 bg-blue-500/20 text-blue-300 rounded text-xs">View</a>
    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-3 py-1 bg-red-500/20 text-red-300 rounded text-xs">Remove</button>
    </form>
</td>
</tr>
@empty
<tr><td colspan="5" class="px-6 py-10 text-center text-gray-500">No users found.</td></tr>
@endforelse
</tbody></table></div>

<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection
