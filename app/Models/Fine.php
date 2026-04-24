<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable = [
        'borrow_id',
        'user_id',
        'amount',
        'overdue_days',
        'status',
        'calculated_at',
        'paid_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'calculated_at' => 'datetime',
            'paid_at' => 'datetime',
            'amount' => 'decimal:2',
        ];
    }

    public function borrow()
    {
        return $this->belongsTo(Borrow::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark fine as paid
     */
    public function markAsPaid($notes = null)
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
            'notes' => $notes,
        ]);
    }

    /**
     * Waive the fine
     */
    public function waive($reason)
    {
        $this->update([
            'status' => 'waived',
            'notes' => $reason,
        ]);
    }
}
