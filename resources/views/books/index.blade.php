@extends($layout ?? 'layouts.librarian')
@section('title', 'Library Books')
@section('content')
@if (session('status'))
    <div class="mb-6 rounded-xl border border-white/10 bg-maroon-900/50 px-5 py-4 text-sm text-gray-200">
        {{ session('status') }}
    </div>
@endif
@if ($errors->any())
    <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 px-5 py-4 text-sm text-red-200">
        {{ $errors->first() }}
    </div>
@endif

<div class="flex items-center gap-4 mb-6">
<form method="GET" action="{{ $searchAction ?? url()->current() }}" class="flex-1 flex gap-3">
    <input type="text" name="q" value="{{ $q ?? request('q') }}" placeholder="Search books..."
        class="flex-1 max-w-md pl-4 py-3 bg-maroon-900/50 border border-white/10 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500">
    
    <select name="department" class="pl-4 py-3 bg-maroon-900/50 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-pink-500">
        <option value="">All Departments</option>
        <option value="Computer Science" {{ request('department') === 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
        <option value="Information Technology" {{ request('department') === 'Information Technology' ? 'selected' : '' }}>Information Technology</option>
        <option value="Business Administration" {{ request('department') === 'Business Administration' ? 'selected' : '' }}>Business Administration</option>
        <option value="Engineering" {{ request('department') === 'Engineering' ? 'selected' : '' }}>Engineering</option>
        <option value="Liberal Arts" {{ request('department') === 'Liberal Arts' ? 'selected' : '' }}>Liberal Arts</option>
        <option value="Natural Sciences" {{ request('department') === 'Natural Sciences' ? 'selected' : '' }}>Natural Sciences</option>
        <option value="Medicine" {{ request('department') === 'Medicine' ? 'selected' : '' }}>Medicine</option>
        <option value="Law" {{ request('department') === 'Law' ? 'selected' : '' }}>Law</option>
        <option value="General" {{ request('department') === 'General' ? 'selected' : '' }}>General</option>
    </select>
    <button type="submit" class="px-5 py-3 bg-pink-600 text-white rounded-xl font-medium hover:bg-pink-700 transition-colors">Filter</button>
</form>
@if (($role ?? '') === 'librarian')
    <a href="{{ route('librarian.books.create') }}" class="px-5 py-3 bg-pink-600 text-white rounded-xl font-medium hover:bg-pink-700 transition-colors">+ Add Book</a>
@endif
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
@forelse($books ?? [] as $book)
@php($active = ($activeBorrows[$book->id] ?? null))
@php($available = (int) $book->available_copies > 0)
<div class="bg-maroon-900/50 rounded-2xl p-6 border border-white/10 hover:border-pink-500/30 transition-colors">
    <div class="w-12 h-12 bg-pink-500/20 rounded-xl flex items-center justify-center mb-4 text-pink-400 text-xl">📖</div>
    <h3 class="text-white font-bold text-lg">{{ $book->title }}</h3>
    <p class="text-gray-400 text-sm mt-1">{{ $book->author }}</p>
    <p class="text-gray-500 text-xs font-mono mt-1">{{ $book->isbn }}</p>
    <p class="text-pink-300 text-xs font-semibold mt-2 bg-pink-500/10 inline-block px-2 py-1 rounded">{{ $book->department }}</p>
    <div class="flex items-center justify-between mt-3">
        <span class="inline-block px-3 py-1 {{ $available ? 'bg-green-500/20 text-green-300' : 'bg-amber-500/20 text-amber-300' }} rounded-lg text-xs font-medium">
            {{ $available ? 'Available' : 'Unavailable' }}
        </span>
        <span class="text-xs text-gray-400">{{ $book->available_copies }} / {{ $book->total_copies }}</span>
    </div>

    <div class="mt-4 flex items-center gap-2">
        @if ($active)
            <form method="POST" action="{{ route('borrows.return', $active) }}">
                @csrf
                <button class="px-4 py-2 bg-amber-500/20 text-amber-200 rounded-xl text-xs font-semibold hover:bg-amber-500/30 transition-colors">Return</button>
            </form>
            <span class="text-xs text-gray-400">Due {{ $active->due_at?->format('M d, Y') }}</span>
        @else
            <form method="POST" action="{{ route('borrows.borrow', $book) }}">
                @csrf
                <button {{ $available ? '' : 'disabled' }} class="px-4 py-2 {{ $available ? 'bg-pink-600 hover:bg-pink-700' : 'bg-white/10 cursor-not-allowed' }} text-white rounded-xl text-xs font-semibold transition-colors">Borrow</button>
            </form>
        @endif
    </div>
</div>
@empty
<div class="col-span-full text-center py-16 text-gray-400">No books found.</div>
@endforelse
</div>
@endsection
