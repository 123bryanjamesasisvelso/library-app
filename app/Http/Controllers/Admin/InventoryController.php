<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $departmentId = $request->query('department');

        $departments = Department::with([
            'books' => function ($q) {
                $q->withCount([
                    'borrows as active_borrows' => fn ($query) => $query->whereNull('returned_at'),
                ])->orderBy('title');
            },
        ])->orderBy('name')->get();

        // Get summary stats
        $stats = [
            'totalDepartments' => $departments->count(),
            'totalBooks' => $departments->sum(fn ($d) => $d->books->count()),
            'totalAvailable' => $departments->sum(fn ($d) => $d->books->sum('available_copies')),
            'totalBorrowed' => $departments->sum(fn ($d) => $d->books->sum(fn ($b) => $b->active_borrows)),
        ];

        return view('admin.inventory', [
            'departments' => $departments,
            'stats' => $stats,
            'selectedDepartment' => $departmentId,
        ]);
    }
}
