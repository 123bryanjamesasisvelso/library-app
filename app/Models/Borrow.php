<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_at',
        'returned_at',
        'status',
        'fine_amount',
        'fine_paid',
        'fine_paid_at',
    ];

    protected function casts(): array
    {
        return [
            'borrowed_at' => 'datetime',
            'due_at' => 'datetime',
            'returned_at' => 'datetime',
            'fine_amount' => 'decimal:2',
            'fine_paid' => 'boolean',
            'fine_paid_at' => 'datetime',
        ];
    }

    public function calculateFine(): float
    {
        if ($this->status === 'returned' || $this->fine_paid) {
            return (float) $this->fine_amount;
        }

        $dueDate = $this->due_at;
        if (! $dueDate) {
            return 0;
        }

        $now = $this->returned_at ?? now();
        if ($now->lte($dueDate)) {
            return 0;
        }

        $daysOverdue = (int) $dueDate->diffInDays($now);
        $finePerDay = 5.00;
        return round($daysOverdue * $finePerDay, 2);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
