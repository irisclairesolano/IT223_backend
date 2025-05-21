<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BookController;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ✅ Public routes — you can test these right away in Postman!
Route::apiResource('books', BookController::class);

// Public user registration
Route::post('/register', [UsersController::class, 'store']);

// 🔐 Login route
Route::post('/login', [AuthController::class, 'login']);

// 🔒 Protected routes (require Sanctum auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UsersController::class);
    Route::get('/dashboard/counts', [DashboardController::class, 'getCounts']);
});

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return response()->json(['message' => 'Database is connected ✅']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Borrow a book
// Route::post('/borrow', [TransactionController::class, 'store']);
// Route::post('/return/{id}', [TransactionController::class, 'returnBook']);
// Route::get('/transactions', [TransactionController::class, 'index']);
// Route::get('/transactions/{id}', [TransactionController::class, 'show']);
// Route::get('/transactions/user/{id}', [TransactionController::class, 'showByUser']);

// // Additional Transaction Routes
// Route::put('/transactions/{id}', [TransactionController::class, 'update']);
// Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);

// Route::apiResource('transactions', TransactionController::class);
Route::post('/borrow', [TransactionController::class, 'store']);
Route::post('/return/{id}', [TransactionController::class, 'returnBook']);


