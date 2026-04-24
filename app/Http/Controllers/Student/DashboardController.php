<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\Fine;
use App\Services\FineService;

class DashboardController extends Controller
{
    protected $fineService;

    public function __construct(FineService $fineService)
    {
        $this->fineService = $fineService;
    }

    public function index()
    {
        $user = auth()->user();
        $now = now();

        // Get all active (not returned) borrows
        $activeBorrows = Borrow::where('user_id', $user->id)
            ->whereNull('returned_at')
            ->with('book')
            ->latest('borrowed_at')
            ->get();

        // Get all returned borrows
        $returnedBorrows = Borrow::where('user_id', $user->id)
            ->whereNotNull('returned_at')
            ->with('book')
            ->latest('returned_at')
            ->limit(5)
            ->get();

        // Separate overdue borrows
        $overdueBorrows = $activeBorrows->filter(function ($borrow) use ($now) {
            return $borrow->due_at < $now;
        });

        // Get all fines for the student
        $allFines = Fine::where('user_id', $user->id)
            ->with('borrow.book')
            ->latest('calculated_at')
            ->get();

        // Calculate totals
        $totalUnpaidFines = $this->fineService->getTotalUnpaidFinesForUser($user->id);
        $totalPaidFines = Fine::where('user_id', $user->id)
            ->where('status', 'paid')
            ->sum('amount');
        $totalWaivedFines = Fine::where('user_id', $user->id)
            ->where('status', 'waived')
            ->sum('amount');

        return view('dashboards.student', [
            'studentName' => $user->name,
            'program' => $user->program,
            'activeBorrows' => $activeBorrows,
            'returnedBorrows' => $returnedBorrows,
            'overdueBorrows' => $overdueBorrows,
            'allFines' => $allFines,
            'stats' => [
                'activeBorrowsCount' => $activeBorrows->count(),
                'overdueCount' => $overdueBorrows->count(),
                'totalFines' => $allFines->sum('amount'),
                'unpaidFines' => $totalUnpaidFines,
                'paidFines' => $totalPaidFines,
                'waivedFines' => $totalWaivedFines,
            ],
        ]);
    }
}
