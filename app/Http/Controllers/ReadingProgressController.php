<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ReadingProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadingProgressController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'page' => 'required|integer|min:1',
        ]);


        ReadingProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'book_id' => $book->id,
            ],
            [
                'last_page' => $request->page,
            ]
        );


        return response()->json([
            'success' => true,
        ]);
    }
}