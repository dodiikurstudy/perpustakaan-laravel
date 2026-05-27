<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favorites()->with('book')->get();

        return view('user.favorites', compact('favorites'));
    }

    public function store(Book $book)
    {
        $user = auth()->user();

        $exists = Favorite::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->exists();

        if (! $exists) {
            Favorite::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
            ]);
        }

        return back()->with('success', 'Buku ditambahkan ke favorit');
    }

    public function destroy(Book $book)
    {
        $user = auth()->user();

        Favorite::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->delete();

        return back()->with('success', 'Buku dihapus dari favorit');
    }
}
