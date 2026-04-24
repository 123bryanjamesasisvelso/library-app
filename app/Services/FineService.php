<?php

namespace App\Services;

use App\Models\Borrow;
use App\Models\Fine;
use Carbon\Carbon;

class FineService
{
    // Fine rate per day in dollars
    protected $finePerDay = 0.50;

    /**
     * Calculate fine for a borrow record
     * Returns null if no fine (returned on time)
     */
    public function calculateFineForBorrow(Borrow $borrow): ?Fine
    {
        // Don't calculate if already returned on time
        if ($borrow->status === 'returned' && $borrow->returned_at <= $borrow->due_at) {
            return null;
        }

        $returnDate = $borrow->returned_at ?? now();
        $dueDate = $borrow->due_at;

        // Check if overdue
        if ($returnDate <= $dueDate) {
            return null;
        }

        $overdaysDays = $dueDate->diffInDays($returnDate);
        $fineAmount = $overdaysDays * $this->finePerDay;

        // Check if fine already exists
        $existingFine = Fine::where('borrow_id', $borrow->id)->first();

        if ($existingFine) {
            $existingFine->update([
                'overdue_days' => $overdaysDays,
                'amount' => $fineAmount,
            ]);
            return $existingFine;
        }

        // Create new fine
        return Fine::create([
            'borrow_id' => $borrow->id,
            'user_id' => $borrow->user_id,
            'amount' => $fineAmount,
            'overdue_days' => $overdaysDays,
            'status' => 'unpaid',
            'calculated_at' => now(),
        ]);
    }

    /**
     * Get all unpaid fines for a user
     */
    public function getUnpaidFinesForUser($userId)
    {
        return Fine::where('user_id', $userId)
            ->where('status', 'unpaid')
            ->with('borrow.book')
            ->get();
    }

    /**
     * Get total unpaid fine amount for a user
     */
    public function getTotalUnpaidFinesForUser($userId): float
    {
        return Fine::where('user_id', $userId)
            ->where('status', 'unpaid')
            ->sum('amount');
    }

    /**
     * Get all overdue borrows for a user (not yet returned)
     */
    public function getOverduesBorrowsForUser($userId)
    {
        return Borrow::where('user_id', $userId)
            ->where('status', 'active')
            ->where('due_at', '<', now())
            ->with('book')
            ->get();
    }

    /**
     * Calculate and create fines for all overdue books (system-wide)
     * Run this periodically via scheduler
     */
    public function processAllOverdueFines()
    {
        $overdueBorrows = Borrow::where('status', 'active')
            ->where('due_at', '<', now())
            ->get();

        $finesCreated = 0;

        foreach ($overdueBorrows as $borrow) {
            // Check if fine already exists
            if (!Fine::where('borrow_id', $borrow->id)->exists()) {
                $overdaysDays = $borrow->due_at->diffInDays(now());
                $fineAmount = $overdaysDays * $this->finePerDay;

                Fine::create([
                    'borrow_id' => $borrow->id,
                    'user_id' => $borrow->user_id,
                    'amount' => $fineAmount,
                    'overdue_days' => $overdaysDays,
                    'status' => 'unpaid',
                    'calculated_at' => now(),
                ]);

                $finesCreated++;
            }
        }

        return $finesCreated;
    }

    /**
     * Set the fine per day rate
     */
    public function setFinePerDay(float $amount): void
    {
        $this->finePerDay = $amount;
    }

    /**
     * Get the current fine per day rate
     */
    public function getFinePerDay(): float
    {
        return $this->finePerDay;
    }
}
