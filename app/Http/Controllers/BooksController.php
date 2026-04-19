<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $user = $request->user();
        $role = (string) ($user->role ?? 'student');

        $books = Book::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('author', 'like', "%{$q}%")
                        ->orWhere('isbn', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->get();

        $activeBorrows = Borrow::query()
            ->where('user_id', $user->id)
            ->whereNull('returned_at')
            ->get()
            ->keyBy('book_id');

        $routePrefix = $role === 'librarian' ? 'librarian' : 'student';

        return view('books.index', [
            'q' => $q,
            'books' => $books,
            'activeBorrows' => $activeBorrows,
            'role' => $role,
            'layout' => $role === 'student' ? 'layouts.student' : 'layouts.librarian',
            'searchAction' => route($routePrefix.'.books'),
        ]);
    }

    public function create()
    {
        abort_unless(auth()->user()?->role === 'librarian', 403);

        return view('books.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()?->role === 'librarian', 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:32', 'unique:books,isbn'],
            'total_copies' => ['required', 'integer', 'min:1'],
        ]);

        $total = (int) $validated['total_copies'];

        Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'],
            'total_copies' => $total,
            'available_copies' => $total,
        ]);

        return redirect()->route('librarian.books')->with('status', 'Book added.');
    }
}
