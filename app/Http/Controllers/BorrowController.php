<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    public function borrow(Request $request, Book $book)
    {
        $user = $request->user();

        DB::transaction(function () use ($user, $book) {
            $book->refresh();

            if ($book->available_copies < 1) {
                abort(422, 'This book is currently unavailable.');
            }

            Borrow::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'borrowed_at' => now(),
                'due_at' => now()->addDays(14),
                'status' => 'active',
            ]);

            $book->decrement('available_copies');
        });

        return back()->with('status', 'Book borrowed successfully.');
    }

    public function return(Request $request, Borrow $borrow)
    {
        $user = $request->user();
        $role = (string) ($user->role ?? 'student');

        if (! in_array($role, ['admin', 'librarian'], true) && $borrow->user_id !== $user->id) {
            abort(403);
        }

        DB::transaction(function () use ($borrow) {
            $borrow->refresh();

            if ($borrow->returned_at) {
                return;
            }

            $borrow->update([
                'returned_at' => now(),
                'status' => 'returned',
            ]);

            $borrow->book()->increment('available_copies');
        });

        return back()->with('status', 'Book returned.');
    }
}
