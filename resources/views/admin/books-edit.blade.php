@extends('layouts.admin')
@section('title', 'Edit Book')
@section('header', 'Edit Book')
@section('content')
<div class="max-w-2xl">
    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 px-5 py-4 text-sm text-red-200">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="bg-library-card rounded-2xl border border-white/5 p-6">
        <form method="POST" action="{{ route('admin.books.update', $book) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm text-gray-300 mb-2">Title</label>
                <input name="title" value="{{ old('title', $book->title) }}" required
                    class="w-full px-4 py-3 bg-library-dark border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-maroon-500">
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-2">Author</label>
                <input name="author" value="{{ old('author', $book->author) }}" required
                    class="w-full px-4 py-3 bg-library-dark border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-maroon-500">
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-2">ISBN</label>
                <input name="isbn" value="{{ old('isbn', $book->isbn) }}" required
                    class="w-full px-4 py-3 bg-library-dark border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-maroon-500">
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-2">Total Copies</label>
                <input type="number" min="1" name="total_copies" value="{{ old('total_copies', $book->total_copies) }}" required
                    class="w-full px-4 py-3 bg-library-dark border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-maroon-500">
                <p class="text-xs text-gray-500 mt-2">Available copies will be recalculated based on active borrows.</p>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button class="px-5 py-3 bg-maroon-600 text-white rounded-xl font-medium hover:bg-maroon-700 transition-colors">Update</button>
                <a href="{{ route('admin.books.index') }}" class="px-5 py-3 bg-white/5 text-gray-200 rounded-xl hover:bg-white/10 transition-colors">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

