<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Add fillable or guarded properties as needed
    protected $fillable = [
        'user_id',
        'book_id',
        'available_copies',
        'borrowed_at',
        'due_at',
        'returned_at',
        'late_fee',
    ];
}
