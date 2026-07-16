<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ReadingProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{

    public function read(Book $book)
    {
        // Admin tidak boleh membaca
        if (Auth::user()->role === 'admin') {
            abort(403, 'Admin tidak dapat membaca ebook.');
        }


        // Hanya ebook digital
        if ($book->tipe !== 'digital') {
            abort(404);
        }


        // File tidak tersedia
        if (!$book->file_buku) {
            abort(404);
        }


        $maxPages = null;


        // user biasa dibatasi
        if (Auth::user()->role === 'user') {
            $maxPages = 10;
        }


        // member bebas
        if (Auth::user()->role === 'member') {
            $maxPages = null;
        }


        $lastPage = ReadingProgress::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->value('last_page');


        $watermark = [
            'name' => Auth::user()->name,
            'npm'  => Auth::user()->npm,
        ];

        return view('ebook.viewer', compact(
            'book',
            'maxPages',
            'lastPage',
            'watermark'
        ));
    }



    public function file(Book $book)
    {

        // Cek login
        if (!Auth::check()) {
            abort(403);
        }


        // Admin tidak boleh akses file
        if (Auth::user()->role === 'admin') {
            abort(403);
        }


        // Pastikan ebook digital
        if ($book->tipe !== 'digital') {
            abort(404);
        }


        // Cek file
        if (!Storage::disk('private')->exists($book->file_buku)) {
            abort(404);
        }


        $path = Storage::disk('private')
            ->path($book->file_buku);



        return response()->file($path, [

            'Content-Type' => 'application/pdf',

            // jangan beri nama file asli
            'Content-Disposition' => 'inline',

            // mencegah cache browser
            'Cache-Control' => 'no-store, no-cache, must-revalidate',

            'Pragma' => 'no-cache',

        ]);

    }

    public function progress(Request $request, Book $book)
    {

        if(!Auth::check())
        {
            abort(403);
        }


        ReadingProgress::updateOrCreate(

            [
                'user_id' => auth()->id(),

                'book_id' => $book->id,
            ],


            [
                'last_page' => $request->page,
            ]

        );


        return response()->json([

            'success' => true

        ]);

    }

}