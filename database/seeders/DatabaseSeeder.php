<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $admin = User::updateOrCreate(
                ['email' => 'admin@library.com'],
                ['name' => 'Admin User', 'password' => Hash::make('password'), 'role' => 'admin']
            );

            $librarian = User::updateOrCreate(
                ['email' => 'librarian@library.com'],
                ['name' => 'Librarian User', 'password' => Hash::make('password'), 'role' => 'librarian']
            );

            $programs = ['bshm', 'bsba', 'educ', 'bscs'];
            $students = User::factory()->count(6)->create();
            $students->each(function ($student, $index) use ($programs) {
                $student->update(['program' => $programs[$index % count($programs)]]);
            });

            $departments = collect([
                ['BSHM', 'Hotel Management'],
                ['BSBA', 'Business Administration'],
                ['EDUC', 'Education'],
                ['BSCS', 'Computer Science'],
            ])->mapWithKeys(function ($d) {
                [$code, $name] = $d;
                $dept = Department::updateOrCreate(
                    ['code' => $code],
                    ['name' => $name]
                );
                return [$code => $dept];
            });

            $books = collect([
                ['The Great Gatsby', 'F. Scott Fitzgerald', '978-0743273565', 12, 'BSHM'],
                ['1984', 'George Orwell', '978-0451524935', 8, 'BSBA'],
                ['To Kill a Mockingbird', 'Harper Lee', '978-0061120084', 15, 'EDUC'],
                ['Pride and Prejudice', 'Jane Austen', '978-0141439518', 10, 'BSCS'],
                ['The Hobbit', 'J.R.R. Tolkien', '978-0547928227', 6, 'BSHM'],
                ['Dune', 'Frank Herbert', '978-0441172719', 9, 'BSBA'],
            ])->map(function ($b) use ($departments) {
                [$title, $author, $isbn, $total, $deptCode] = $b;

                return Book::updateOrCreate(
                    ['isbn' => $isbn],
                    [
                        'title' => $title,
                        'author' => $author,
                        'total_copies' => $total,
                        'available_copies' => $total,
                        'department_id' => $departments[$deptCode]->id,
                    ]
                );
            });

            // Clear previous borrow samples to keep seeding idempotent-ish.
            Borrow::query()->delete();

            $sampleUsers = $students->take(3)->values();
            $sampleBooks = $books->take(4)->values();

            // Active borrow
            Borrow::create([
                'user_id' => $sampleUsers[0]->id,
                'book_id' => $sampleBooks[1]->id,
                'borrowed_at' => now()->subHours(2),
                'due_at' => now()->addDays(12),
                'returned_at' => null,
                'status' => 'active',
            ]);
            $sampleBooks[1]->decrement('available_copies');

            // Returned borrow
            Borrow::create([
                'user_id' => $sampleUsers[1]->id,
                'book_id' => $sampleBooks[0]->id,
                'borrowed_at' => now()->subDays(3),
                'due_at' => now()->subDay(),
                'returned_at' => now()->subDays(1),
                'status' => 'returned',
            ]);

            // Overdue borrow (6 days overdue = $30 fine)
            Borrow::create([
                'user_id' => $sampleUsers[2]->id,
                'book_id' => $sampleBooks[2]->id,
                'borrowed_at' => now()->subDays(20),
                'due_at' => now()->subDays(6),
                'returned_at' => null,
                'status' => 'overdue',
                'fine_amount' => 30.00,
            ]);
            $sampleBooks[2]->decrement('available_copies');

            // Librarian borrows one
            Borrow::create([
                'user_id' => $librarian->id,
                'book_id' => $sampleBooks[3]->id,
                'borrowed_at' => now()->subDays(1),
                'due_at' => now()->addDays(13),
                'returned_at' => null,
                'status' => 'active',
            ]);
            $sampleBooks[3]->decrement('available_copies');
        });
    }
}
