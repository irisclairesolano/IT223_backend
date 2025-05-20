<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Transaction;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
        ]);

        // Create 15 users
        User::factory(15)->create();

        // Create 15 books
        Book::factory(15)->create();

        Transaction::factory(15)->create();
    }
}
