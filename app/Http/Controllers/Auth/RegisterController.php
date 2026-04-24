<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function createAdmin()
    {
        return view('auth.register', [
            'role' => 'admin',
            'roleLabel' => 'Admin',
        ]);
    }

    public function createStudent()
    {
        return view('auth.register', [
            'role' => 'student',
            'roleLabel' => 'Student',
        ]);
    }

    public function store(RegisterRequest $request, string $role)
    {
        if (! in_array($role, ['admin', 'student'], true)) {
            abort(404);
        }

        $userData = [
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->toString(),
            'password' => Hash::make($request->string('password')->toString()),
            'role' => $role,
        ];

        // Include program for students
        if ($role === 'student' && $request->filled('program')) {
            $userData['program'] = $request->string('program')->toString();
        }

        $user = User::create($userData);

        Auth::login($user);

        return redirect(match ($role) {
            'admin' => '/admin/dashboard',
            default => '/student/dashboard',
        });
    }
}
