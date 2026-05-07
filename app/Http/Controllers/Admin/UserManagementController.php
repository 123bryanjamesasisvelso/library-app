<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $users = User::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->withCount('borrows')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users', [
            'users' => $users,
            'q' => $q,
        ]);
    }

    public function show(User $user)
    {
        $user->load(['borrows.book' => function ($q) {
            $q->select('id', 'title', 'author', 'isbn');
        }]);

        return view('admin.users-show', [
            'user' => $user,
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['user' => 'You cannot remove your own account.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User removed.');
    }
}
