<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Borrow;

class ProfileController extends Controller
{
    public function admin()
    {
        $user = auth()->user();

        $borrows = Borrow::query()
            ->with('book:id,title,author,isbn')
            ->where('user_id', $user->id)
            ->latest('borrowed_at')
            ->get();

        return view('profiles.admin', [
            'user' => $user,
            'stats' => $this->borrowStats($borrows),
            'borrows' => $borrows,
        ]);
    }

    public function librarian()
    {
        $user = auth()->user();

        $borrows = Borrow::query()
            ->with('book:id,title,author,isbn')
            ->where('user_id', $user->id)
            ->latest('borrowed_at')
            ->get();

        return view('profiles.librarian', [
            'user' => $user,
            'stats' => $this->borrowStats($borrows),
            'borrows' => $borrows,
        ]);
    }

    private function borrowStats($borrows): array
    {
        $total = $borrows->count();
        $currently = $borrows->whereNull('returned_at')->count();
        $overdue = $borrows->whereNull('returned_at')->filter(fn ($b) => $b->due_at?->isPast())->count();
        $returned = $borrows->whereNotNull('returned_at')->count();

        return compact('total', 'currently', 'overdue', 'returned');
    }
}
