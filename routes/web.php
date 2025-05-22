<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        "message" => "Welcome to the Library Management API",
        "endpoints" => [
            "books" => [
                "GET /books" => "List all books",
                "POST /books" => "Create a new book"
            ],
            "users" => [
                "GET /users" => "List all users",
                "POST /login" => "User login",
                "GET /user" => "Get current user info (authenticated)"
            ],
            "transactions" => [
                "GET /transactions" => "List all transactions",
                "GET /transactions/{id}" => "Get details of a specific transaction"
            ],
            "borrow_return" => [
                "POST /borrow" => "Borrow a book",
                "POST /return/{id}" => "Return a borrowed book by transaction id"
            ]
        ]
    ]);                        
});
