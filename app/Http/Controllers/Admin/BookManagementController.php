<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBookRequest;
use App\Http\Requests\Admin\UpdateBookRequest;
use App\Models\Book;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookManagementController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $departmentId = $request->query('department');

        $books = Book::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('author', 'like', "%{$q}%")
                        ->orWhere('isbn', 'like', "%{$q}%");
                });
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })
            ->with(['department:id,name,code'])
            ->withCount([
                'borrows as borrowed_count' => fn ($q) => $q->whereNull('returned_at'),
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.books', [
            'books' => $books,
            'q' => $q,
            'departments' => Department::orderBy('name')->get(),
            'selectedDepartment' => $departmentId,
        ]);
    }

    public function create()
    {
        return view('admin.books-create', [
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function store(StoreBookRequest $request)
    {
        $total = (int) $request->input('total_copies');

        Book::create([
            'title' => $request->string('title')->toString(),
            'author' => $request->string('author')->toString(),
            'isbn' => $request->string('isbn')->toString(),
            'total_copies' => $total,
            'available_copies' => $total,
            'department_id' => $request->input('department_id'),
        ]);

        return redirect()->route('admin.books.index')->with('status', 'Book added.');
    }

    public function edit(Book $book)
    {
        return view('admin.books-edit', [
            'book' => $book,
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $request->validate([
            'isbn' => ['required', 'string', 'max:32', Rule::unique('books', 'isbn')->ignore($book->id)],
        ]);

        $total = (int) $request->input('total_copies');

        $currentlyBorrowed = max(0, (int) $book->total_copies - (int) $book->available_copies);
        $available = max(0, $total - $currentlyBorrowed);

        $book->update([
            'title' => $request->string('title')->toString(),
            'author' => $request->string('author')->toString(),
            'isbn' => $request->string('isbn')->toString(),
            'total_copies' => $total,
            'available_copies' => $available,
            'department_id' => $request->input('department_id'),
        ]);

        return redirect()->route('admin.books.index')->with('status', 'Book updated.');
    }

    public function destroy(Book $book)
    {
        $activeBorrows = $book->borrows()->whereNull('returned_at')->count();

        if ($activeBorrows > 0) {
            return back()->withErrors(['book' => 'This book has active borrows and cannot be removed.']);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('status', 'Book removed.');
    }
}
