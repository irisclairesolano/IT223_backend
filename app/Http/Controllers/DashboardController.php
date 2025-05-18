<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function getCounts()
    {
        return response()->json([
            'total_users' => User::count(),
            'total_books' => Book::count()
        ]);
    }
} 