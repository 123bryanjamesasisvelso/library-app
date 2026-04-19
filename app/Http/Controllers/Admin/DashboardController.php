<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();
        $last30 = [$now->copy()->subDays(30), $now];
        $prev30 = [$now->copy()->subDays(60), $now->copy()->subDays(30)];

        $totalUsers = User::count();
        $totalBooks = Book::count();
        $totalBorrows = Borrow::count();

        $usersChange = $this->pctChange(
            User::whereBetween('created_at', $prev30)->count(),
            User::whereBetween('created_at', $last30)->count()
        );
        $booksChange = $this->pctChange(
            Book::whereBetween('created_at', $prev30)->count(),
            Book::whereBetween('created_at', $last30)->count()
        );
        $borrowsChange = $this->pctChange(
            Borrow::whereBetween('borrowed_at', $prev30)->count(),
            Borrow::whereBetween('borrowed_at', $last30)->count()
        );

        $recentUsers = User::latest()->limit(5)->get();
        $recentBooks = Book::latest()->limit(5)->get();

        $recentBorrows = Borrow::query()
            ->with(['user:id,name,email,role', 'book:id,title,author'])
            ->latest('borrowed_at')
            ->limit(6)
            ->get();

        return view('dashboards.admin', [
            'adminName' => auth()->user()->name ?? 'Admin',
            'stats' => [
                'totalUsers' => $totalUsers,
                'totalBooks' => $totalBooks,
                'totalBorrows' => $totalBorrows,
                'usersChange' => $usersChange,
                'booksChange' => $booksChange,
                'borrowsChange' => $borrowsChange,
            ],
            'recentUsers' => $recentUsers,
            'recentBooks' => $recentBooks,
            'recentBorrows' => $recentBorrows,
        ]);
    }

    public function overview()
    {
        $now = now();
        $last30 = [$now->copy()->subDays(30), $now];
        $prev30 = [$now->copy()->subDays(60), $now->copy()->subDays(30)];

        $totalBooks = Book::sum('total_copies');
        $availableBooks = Book::sum('available_copies');
        $borrowedBooks = max(0, $totalBooks - $availableBooks);
        $overdueBorrows = Borrow::whereNull('returned_at')->where('due_at', '<', $now)->count();

        $recentActivity = Borrow::query()
            ->with(['user:id,name', 'book:id,title'])
            ->latest('borrowed_at')
            ->limit(6)
            ->get()
            ->map(function (Borrow $b) use ($now) {
                $status = $b->returned_at ? 'Returned' : ($b->due_at->lt($now) ? 'Overdue' : 'Active');
                return [
                    'text' => ($b->user?->name ?? 'Someone').' '.($b->returned_at ? 'returned' : 'borrowed').' "'.($b->book?->title ?? 'a book').'"',
                    'at' => $b->borrowed_at,
                    'status' => strtolower($status),
                    'statusLabel' => $status,
                ];
            });

        $popularBooks = Book::query()
            ->withCount('borrows')
            ->orderByDesc('borrows_count')
            ->limit(6)
            ->get();

        return view('dashboards.admin-view', [
            'adminName' => auth()->user()->name ?? 'Admin',
            'stats' => [
                'totalBooks' => $totalBooks,
                'availableBooks' => $availableBooks,
                'borrowedBooks' => $borrowedBooks,
                'overdueBooks' => $overdueBorrows,
                'totalBooksChange' => $this->pctChange(
                    Book::whereBetween('created_at', $prev30)->count(),
                    Book::whereBetween('created_at', $last30)->count()
                ),
                'overdueChange' => $this->pctChange(
                    Borrow::whereNull('returned_at')->whereBetween('due_at', $prev30)->where('due_at', '<', $prev30[1])->count(),
                    Borrow::whereNull('returned_at')->whereBetween('due_at', $last30)->where('due_at', '<', $last30[1])->count()
                ),
            ],
            'recentActivity' => $recentActivity,
            'popularBooks' => $popularBooks,
        ]);
    }

    private function pctChange(int $prev, int $current): float
    {
        if ($prev <= 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return (($current - $prev) / $prev) * 100.0;
    }
}
