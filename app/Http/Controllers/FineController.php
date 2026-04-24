<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\User;
use App\Services\FineService;
use Illuminate\Http\Request;

class FineController extends Controller
{
    protected $fineService;

    public function __construct(FineService $fineService)
    {
        $this->fineService = $fineService;
    }

    /**
     * View fines for the current user (Student view)
     */
    public function myFines(Request $request)
    {
        $user = $request->user();
        $fines = Fine::where('user_id', $user->id)
            ->with('borrow.book')
            ->orderBy('status')
            ->latest()
            ->get();

        $totalUnpaid = $this->fineService->getTotalUnpaidFinesForUser($user->id);

        return view('fines.my-fines', [
            'fines' => $fines,
            'totalUnpaid' => $totalUnpaid,
        ]);
    }

    /**
     * Admin view: Manage all fines
     */
    public function index(Request $request)
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        $status = $request->query('status');
        $query = Fine::with('user', 'borrow.book');

        if ($status && in_array($status, ['paid', 'unpaid', 'waived'], true)) {
            $query->where('status', $status);
        }

        $fines = $query->latest()->paginate(20);

        return view('fines.index', [
            'fines' => $fines,
            'currentStatus' => $status,
        ]);
    }

    /**
     * Mark a fine as paid
     */
    public function markAsPaid(Request $request, Fine $fine)
    {
        $user = $request->user();
        $role = (string) ($user->role ?? 'student');

        // Only admin or the fine owner can mark as paid
        if ($role !== 'admin' && $fine->user_id !== $user->id) {
            abort(403);
        }

        $fine->markAsPaid($request->input('notes'));

        return back()->with('status', 'Fine marked as paid.');
    }

    /**
     * Waive a fine (Admin only)
     */
    public function waive(Request $request, Fine $fine)
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        $validated = $request->validate([
            'reason' => ['required', 'string', 'max:255'],
        ]);

        $fine->waive($validated['reason']);

        return back()->with('status', 'Fine waived.');
    }

    /**
     * Get overdue items for a user
     */
    public function overdueItems(Request $request, ?User $user = null)
    {
        $targetUser = $user ?? $request->user();
        $overdueItems = $this->fineService->getOverduesBorrowsForUser($targetUser->id);

        return view('fines.overdue-items', [
            'overdueItems' => $overdueItems,
            'user' => $targetUser,
        ]);
    }
}
