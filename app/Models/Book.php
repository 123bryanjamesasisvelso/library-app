<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'total_copies',
        'available_copies',
        'department_id',
    ];

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
