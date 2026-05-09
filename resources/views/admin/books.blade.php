@extends('layouts.admin')
@section('title', 'Book Management')
@section('header', '📚 Book Management')
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
    <div class="flex flex-col md:flex-row items-start md:items-center gap-4 mb-6">
        <div class="flex-1 w-full">
            <h2 class="text-lg font-bold text-white mb-3">🔍 Find Books</h2>
            <form method="GET" action="{{ route('admin.books.index') }}" class="flex items-center gap-3 flex-wrap">
                <input type="text" name="q" value="{{ $q ?? request('q') }}" placeholder="Search by title, author, or ISBN…"
                    class="flex-1 min-w-[200px] pl-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-maroon-500 transition-all">
                @if (!empty($departments))
                    <select name="department" class="px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-maroon-500">
                        <option value="">All Departments</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}" {{ ($selectedDepartment ?? '') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                @endif
                <button type="submit" class="px-6 py-3 bg-maroon-600 hover:bg-maroon-700 text-white rounded-xl font-medium transition-colors whitespace-nowrap">
                    Search
                </button>
            </form>
        </div>
        <a href="{{ route('admin.books.create') }}" class="px-6 py-3 bg-gradient-to-r from-gold-500 to-gold-600 hover:from-gold-600 hover:to-gold-700 text-gray-900 rounded-xl font-bold transition-all shadow-lg shadow-gold-500/30 whitespace-nowrap flex items-center gap-2">
            ➕ Add New Book
        </a>
    </div>
</div>
<div class="bg-library-card rounded-2xl border border-white/10 overflow-hidden shadow-lg">
<div class="overflow-x-auto">
<table class="w-full text-sm">
    <thead class="bg-maroon-900/50 border-b border-white/10">
        <tr class="text-gray-300">
            <th class="text-left px-6 py-4 font-semibold">📖 Title</th>
            <th class="px-6 py-4 font-semibold">Author</th>
            <th class="px-6 py-4 font-semibold">Department</th>
            <th class="px-6 py-4 font-semibold">ISBN</th>
            <th class="px-6 py-4 font-semibold">📦 Inventory</th>
            <th class="px-6 py-4 font-semibold">Borrowed</th>
            <th class="text-right px-6 py-4 font-semibold">⚙️ Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($books as $book)
        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
            <td class="px-6 py-4 text-white">
                <div class="flex items-start gap-3">
                    <span class="text-xl">📚</span>
                    <div>
                        <p class="font-semibold">{{ $book->title }}</p>
                        <p class="text-gray-400 text-xs">{{ $book->author }}</p>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 text-gray-300 text-xs">{{ $book->author }}</td>
            <td class="px-6 py-4">
                @if ($book->department)
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-cyan-500/20 text-cyan-300 rounded-lg text-xs font-medium">
                        🏢 {{ $book->department->name }}
                    </span>
                @else
                    <span class="text-gray-500 text-xs">—</span>
                @endif
            </td>
            <td class="px-6 py-4 text-gray-400 font-mono text-xs">{{ $book->isbn }}</td>
            <td class="px-6 py-4">
                <div class="flex items-center gap-2">
                    <span class="px-2 py-1 bg-green-500/20 text-green-300 rounded text-xs font-bold">✓ {{ $book->available_copies }}</span>
                    <span class="text-gray-500 text-xs">/ {{ $book->total_copies }}</span>
                </div>
            </td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 {{ $book->borrowed_count > 0 ? 'bg-amber-500/20 text-amber-300' : 'bg-gray-500/20 text-gray-300' }} rounded text-xs font-medium">
                    {{ $book->borrowed_count ?? 0 }}
                </span>
            </td>
            <td class="px-6 py-4 text-right space-x-2">
                <a href="{{ route('admin.books.edit', $book) }}" class="inline-block px-3 py-2 bg-amber-500/20 text-amber-300 hover:bg-amber-500/30 rounded-lg text-xs font-medium transition-colors">
                    ✏️ Edit
                </a>
                <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="inline" onsubmit="return confirm('Are you sure?');">
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
            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                <div class="text-4xl mb-2">📭</div>
                <p>No books found. Add your first book to get started!</p>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
</div>

<div class="mt-6">
    {{ $books->links() }}
</div>
@endsection
