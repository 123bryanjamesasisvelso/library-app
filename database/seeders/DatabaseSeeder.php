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

            $students = User::factory()->count(6)->create();

            $books = collect([
                ['The Great Gatsby', 'F. Scott Fitzgerald', '978-0743273565', 12],
                ['1984', 'George Orwell', '978-0451524935', 8],
                ['To Kill a Mockingbird', 'Harper Lee', '978-0061120084', 15],
                ['Pride and Prejudice', 'Jane Austen', '978-0141439518', 10],
                ['The Hobbit', 'J.R.R. Tolkien', '978-0547928227', 6],
                ['Dune', 'Frank Herbert', '978-0441172719', 9],
            ])->map(function ($b) {
                [$title, $author, $isbn, $total] = $b;

                return Book::updateOrCreate(
                    ['isbn' => $isbn],
                    [
                        'title' => $title,
                        'author' => $author,
                        'total_copies' => $total,
                        'available_copies' => $total,
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
