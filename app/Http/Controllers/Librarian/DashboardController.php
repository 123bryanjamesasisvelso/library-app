<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrow;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();

        $totalBooks = Book::sum('total_copies');
        $availableBooks = Book::sum('available_copies');
        $borrowedBooks = max(0, $totalBooks - $availableBooks);
        $overdue = Borrow::whereNull('returned_at')->where('due_at', '<', $now)->count();

        $myBorrowed = Borrow::where('user_id', auth()->id())->whereNull('returned_at')->count();

        $recentActivity = Borrow::query()
            ->with(['user:id,name', 'book:id,title'])
            ->latest('borrowed_at')
            ->limit(6)
            ->get();

        $popularBooks = Book::query()
            ->withCount('borrows')
            ->orderByDesc('borrows_count')
            ->limit(5)
            ->get();

        return view('dashboards.librarian', [
            'name' => auth()->user()->name ?? 'Librarian',
            'stats' => [
                'total' => $totalBooks,
                'available' => $availableBooks,
                'borrowed' => $borrowedBooks,
                'overdue' => $overdue,
                'myBorrowed' => $myBorrowed,
            ],
            'recentActivity' => $recentActivity,
            'popularBooks' => $popularBooks,
        ]);
    }
}
