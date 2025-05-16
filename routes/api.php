<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BookController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ✅ Public routes — you can test these right away in Postman!
Route::apiResource('books', BookController::class);

// Public user registration
Route::post('/register', [UsersController::class, 'store']);

// 🔐 Login route for generating Sanctum token
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);
});

// 🔒 Protected routes (require Sanctum auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UsersController::class, 'index']);
    Route::get('/users/{user}', [UsersController::class, 'show']);
    Route::put('/users/{user}', [UsersController::class, 'update']);
    Route::delete('/users/{user}', [UsersController::class, 'destroy']);
});

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return response()->json(['message' => 'Database is connected ✅']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
