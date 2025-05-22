<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Book;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Get all transactions with user and book
    public function index()
    {
        $transactions = Transaction::with(['user', 'book'])->get();
        return response()->json($transactions);
    }

    // Borrow a book
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->available_copies <= 0) {
            return response()->json(['message' => 'No available copies.'], 400);
        }

        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_at' => now()->addDays(7),
        ]);

        $book->decrement('available_copies');

        return response()->json([
            'message' => 'Book borrowed!',
            'transaction' => $transaction,
        ]);
    }

    // Return a book
    public function returnBook($id)
    {
        $transaction = Transaction::with('book')->find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($transaction->returned_at !== null) {
            return response()->json(['message' => 'Book already returned'], 400);
        }

        $now = now();
        $transaction->returned_at = $now;

        if ($now->gt($transaction->due_at)) {
            $daysLate = $now->diffInDays($transaction->due_at);
            $feePerDay = 5;
            $transaction->late_fee = $daysLate * $feePerDay;
        }

        $transaction->save();
        $transaction->book->increment('available_copies');

        return response()->json([
            'message' => 'Book returned!',
            'late_fee' => $transaction->late_fee ?? 0,
        ]);
    }
}
