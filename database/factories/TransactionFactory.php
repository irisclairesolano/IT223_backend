<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;



class TransactionFactory extends Factory
{
    use HasFactory;
    
    protected $model = Transaction::class;

    public function definition(): array
    {
        $borrowedAt = $this->faker->dateTimeBetween('-30 days', 'now');
        $dueAt = (clone $borrowedAt)->modify('+7 days');
        
        // 50% chance the book is returned
        $returnedAt = $this->faker->boolean(50) 
            ? (clone $borrowedAt)->modify('+'.random_int(1, 14).' days') 
            : null;

        // If returned late, calculate late fee (₱10 per day late)
        $lateDays = $returnedAt && $returnedAt > $dueAt 
            ? $returnedAt->diff($dueAt)->days 
            : 0;

        $lateFee = $lateDays * 10;

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'book_id' => Book::inRandomOrder()->first()?->id ?? Book::factory(),
            'available_copies' => $this->faker->numberBetween(0, 10),
            'borrowed_at' => $borrowedAt,
            'due_at' => $dueAt,
            'returned_at' => $returnedAt,
            'late_fee' => $lateFee,
        ];
    }
}
