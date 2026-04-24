<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\BookManagementController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\Librarian\DashboardController as LibrarianDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('landing');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register/admin', [RegisterController::class, 'createAdmin'])->name('register.admin');
    Route::get('/register/student', [RegisterController::class, 'createStudent'])->name('register.student');
    Route::post('/register/{role}', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/overview', [AdminDashboardController::class, 'overview'])->name('admin.dashboard.overview');
    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('admin.users.show');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/books', [BookManagementController::class, 'index'])->name('admin.books.index');
    Route::get('/books/create', [BookManagementController::class, 'create'])->name('admin.books.create');
    Route::post('/books', [BookManagementController::class, 'store'])->name('admin.books.store');
    Route::get('/books/{book}/edit', [BookManagementController::class, 'edit'])->name('admin.books.edit');
    Route::put('/books/{book}', [BookManagementController::class, 'update'])->name('admin.books.update');
    Route::delete('/books/{book}', [BookManagementController::class, 'destroy'])->name('admin.books.destroy');
    
    Route::get('/fines', [FineController::class, 'index'])->name('admin.fines.index');
    Route::post('/fines/{fine}/mark-as-paid', [FineController::class, 'markAsPaid'])->name('admin.fines.mark-paid');
    Route::post('/fines/{fine}/waive', [FineController::class, 'waive'])->name('admin.fines.waive');
    
    Route::get('/profile', [ProfileController::class, 'admin'])->name('admin.profile');
});

Route::prefix('librarian')->middleware(['auth', 'role:librarian'])->group(function () {
    Route::get('/dashboard', [LibrarianDashboardController::class, 'index'])->name('librarian.dashboard');
    Route::get('/books', [BooksController::class, 'index'])->name('librarian.books');
    Route::get('/books/create', [BooksController::class, 'create'])->name('librarian.books.create');
    Route::post('/books', [BooksController::class, 'store'])->name('librarian.books.store');
    Route::get('/profile', [ProfileController::class, 'librarian'])->name('librarian.profile');
});

Route::prefix('student')->middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/books', [BooksController::class, 'index'])->name('student.books');
    Route::get('/fines', [FineController::class, 'myFines'])->name('student.fines');
});

Route::middleware(['auth', 'role:librarian,student'])->group(function () {
    Route::post('/books/{book}/borrow', [BorrowController::class, 'borrow'])->name('borrows.borrow');
    Route::post('/borrows/{borrow}/return', [BorrowController::class, 'return'])->name('borrows.return');
});
