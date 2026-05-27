<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Book $book)
    {
        Comment::create([

            'book_id' => $book->id,
            'user_id' => auth()->id(),
            'isi' => $request->isi,
            'rating' => $request->rating,

        ]);

        return redirect()->back();
    }
}