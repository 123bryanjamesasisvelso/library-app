@extends('layouts.admin')
@section('title', 'Book Management')
@section('header', 'Book Management')
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

<div class="flex items-center gap-4 mb-6">
<form method="GET" action="{{ route('admin.books.index') }}" class="flex-1">
    <input type="text" name="q" value="{{ $q ?? request('q') }}" placeholder="Search by title, author, or ISBN..."
        class="w-full max-w-md pl-4 py-3 bg-library-card border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-maroon-500">
</form>
<a href="{{ route('admin.books.create') }}" class="px-5 py-3 bg-maroon-600 text-white rounded-xl font-medium hover:bg-maroon-700 transition-colors">+ Add New Book</a>
</div>
<div class="bg-library-card rounded-2xl border border-white/5 overflow-hidden">
<table class="w-full text-sm"><thead><tr class="border-b border-white/10 text-gray-400"><th class="text-left px-6 py-4">Title</th><th class="px-6 py-4">ISBN</th><th class="px-6 py-4">Inventory</th><th class="px-6 py-4">Borrowed</th><th class="text-right px-6 py-4">Actions</th></tr></thead>
<tbody>
@forelse($books as $book)
<tr class="border-b border-white/5 hover:bg-library-hover">
<td class="px-6 py-4 text-white font-medium">{{ $book->title }}<br><span class="text-gray-500 text-xs">{{ $book->author }}</span></td>
<td class="px-6 py-4 text-gray-400 font-mono text-xs">{{ $book->isbn }}</td>
<td class="px-6 py-4 text-gray-300">{{ $book->available_copies }} / {{ $book->total_copies }}</td>
<td class="px-6 py-4 text-gray-300">{{ $book->borrowed_count ?? 0 }}</td>
<td class="px-6 py-4 text-right space-x-2">
    <a href="{{ route('admin.books.edit', $book) }}" class="inline-block px-3 py-1 bg-amber-500/20 text-amber-300 rounded text-xs">Edit</a>
    <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-3 py-1 bg-red-500/20 text-red-300 rounded text-xs">Remove</button>
    </form>
</td>
</tr>
@empty
<tr><td colspan="5" class="px-6 py-10 text-center text-gray-500">No books found.</td></tr>
@endforelse
</tbody></table></div>

<div class="mt-6">
    {{ $books->links() }}
</div>
@endsection
