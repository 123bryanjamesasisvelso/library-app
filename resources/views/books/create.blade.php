@extends('layouts.librarian')
@section('title', 'Add Book')
@section('content')
<div class="max-w-2xl">
    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 px-5 py-4 text-sm text-red-200">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="bg-maroon-900/50 rounded-2xl border border-white/10 p-6">
        <h2 class="text-white font-bold text-xl mb-4">Add New Book</h2>
        <form method="POST" action="{{ route('librarian.books.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm text-gray-300 mb-2">Title</label>
                <input name="title" value="{{ old('title') }}" required
                    class="w-full px-4 py-3 bg-maroon-950/60 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-2">Author</label>
                <input name="author" value="{{ old('author') }}" required
                    class="w-full px-4 py-3 bg-maroon-950/60 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-2">Department / Category</label>
                <select name="department" required
                    class="w-full px-4 py-3 bg-maroon-950/60 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500">
                    <option value="">Select a department</option>
                    <option value="Computer Science" {{ old('department') === 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                    <option value="Information Technology" {{ old('department') === 'Information Technology' ? 'selected' : '' }}>Information Technology</option>
                    <option value="Business Administration" {{ old('department') === 'Business Administration' ? 'selected' : '' }}>Business Administration</option>
                    <option value="Engineering" {{ old('department') === 'Engineering' ? 'selected' : '' }}>Engineering</option>
                    <option value="Liberal Arts" {{ old('department') === 'Liberal Arts' ? 'selected' : '' }}>Liberal Arts</option>
                    <option value="Natural Sciences" {{ old('department') === 'Natural Sciences' ? 'selected' : '' }}>Natural Sciences</option>
                    <option value="Medicine" {{ old('department') === 'Medicine' ? 'selected' : '' }}>Medicine</option>
                    <option value="Law" {{ old('department') === 'Law' ? 'selected' : '' }}>Law</option>
                    <option value="General" {{ old('department') === 'General' ? 'selected' : '' }}>General</option>
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-2">ISBN</label>
                <input name="isbn" value="{{ old('isbn') }}" required
                    class="w-full px-4 py-3 bg-maroon-950/60 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-2">Total Copies</label>
                <input type="number" min="1" name="total_copies" value="{{ old('total_copies', 1) }}" required
                    class="w-full px-4 py-3 bg-maroon-950/60 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button class="px-5 py-3 bg-pink-600 text-white rounded-xl font-medium hover:bg-pink-700 transition-colors">Save</button>
                <a href="{{ route('librarian.books') }}" class="px-5 py-3 bg-white/5 text-gray-200 rounded-xl hover:bg-white/10 transition-colors">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

