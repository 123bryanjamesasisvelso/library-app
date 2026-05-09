<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Borrow;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $now = now();

        // Get all borrows for the student
        $allBorrows = Borrow::query()
            ->where('user_id', $user->id)
            ->with(['book:id,title,author,isbn,department_id'])
            ->latest('borrowed_at')
            ->get();

        // Separate active and returned
        $activeBorrows = $allBorrows->filter(fn ($b) => ! $b->returned_at);
        $returnedBorrows = $allBorrows->filter(fn ($b) => $b->returned_at);

        // Calculate overdue and fines
        $overdueBorrows = $activeBorrows->filter(fn ($b) => $b->due_at?->lt($now));
        $totalFinesOwed = $overdueBorrows->sum(fn ($b) => $b->calculateFine());
        $unpaidFinesAmount = $returnedBorrows
            ->filter(fn ($b) => ! $b->fine_paid && $b->fine_amount > 0)
            ->sum('fine_amount');

        return view('dashboards.student', [
            'studentName' => $user->name ?? 'Student',
            'program' => strtoupper($user->program ?? 'N/A'),
            'stats' => [
                'activeBorrows' => $activeBorrows->count(),
                'overdue' => $overdueBorrows->count(),
                'returned' => $returnedBorrows->count(),
                'finesOwed' => $totalFinesOwed,
                'unpaidFines' => $unpaidFinesAmount,
            ],
            'activeBorrows' => $activeBorrows->take(10),
            'overdueBorrows' => $overdueBorrows,
            'borrowHistory' => $returnedBorrows->take(5),
        ]);
    }
}
