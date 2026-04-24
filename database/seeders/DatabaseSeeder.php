<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrow;
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

            $students = User::factory()->count(6)->create([
                'program' => collect(['BSCS', 'BSHM', 'BSBA', 'EDUC'])
                    ->random()
            ]);

            $books = collect([
                ['The Great Gatsby', 'F. Scott Fitzgerald', '978-0743273565', 12, 'Liberal Arts'],
                ['1984', 'George Orwell', '978-0451524935', 8, 'Liberal Arts'],
                ['To Kill a Mockingbird', 'Harper Lee', '978-0061120084', 15, 'Liberal Arts'],
                ['Pride and Prejudice', 'Jane Austen', '978-0141439518', 10, 'Liberal Arts'],
                ['The Hobbit', 'J.R.R. Tolkien', '978-0547928227', 6, 'Liberal Arts'],
                ['Dune', 'Frank Herbert', '978-0441172719', 9, 'Natural Sciences'],
                ['Introduction to Algorithms', 'Thomas Cormen', '978-0262033848', 5, 'Computer Science'],
                ['Design Patterns', 'Gang of Four', '978-0201633610', 4, 'Computer Science'],
                ['Principles of Economics', 'N. Gregory Mankiw', '978-0357456553', 7, 'Business Administration'],
                ['Organic Chemistry', 'Jonathan Clayden', '978-0199270293', 3, 'Natural Sciences'],
            ])->map(function ($b) {
                [$title, $author, $isbn, $total, $department] = $b;

                return Book::updateOrCreate(
                    ['isbn' => $isbn],
                    [
                        'title' => $title,
                        'author' => $author,
                        'total_copies' => $total,
                        'available_copies' => $total,
                        'department' => $department,
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

            // Overdue borrow
            Borrow::create([
                'user_id' => $sampleUsers[2]->id,
                'book_id' => $sampleBooks[2]->id,
                'borrowed_at' => now()->subDays(20),
                'due_at' => now()->subDays(6),
                'returned_at' => null,
                'status' => 'overdue',
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
