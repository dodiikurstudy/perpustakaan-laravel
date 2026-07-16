<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ReadingProgress;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // =========================
    // LIST BUKU ADMIN
    // =========================
    public function index()
{
    $physicalBooks = Book::where('tipe', 'fisik')
        ->latest()
        ->paginate(10, ['*'], 'fisik_page')
        ->withQueryString();

    $digitalBooks = Book::where('tipe', 'digital')
        ->latest()
        ->paginate(10, ['*'], 'digital_page')
        ->withQueryString();

    return view('books.index', compact(
        'physicalBooks',
        'digitalBooks'
    ));
}

    // =========================
    // DETAIL BUKU
    // =========================
    public function show(Book $book)
    {

        $progress = null;


        if(auth()->check())
        {
            $progress = ReadingProgress::where('user_id', auth()->id())
                ->where('book_id', $book->id)
                ->first();
        }


        return view('user.detail-book', compact(
            'book',
            'progress'
        ));

    }

    // =========================
    // FORM CREATE
    // =========================
    public function create()
    {
        return view('books.create');
    }

    // =========================
    // SIMPAN BUKU
    // =========================
    public function store(Request $request)
    {
        $request->validate([

            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'kategori' => 'required',
            'stok' => 'required|integer',
            'tipe' => 'required',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_buku' => 'nullable|mimes:pdf|max:20480',

        ]);

        $cover = null;
        $fileBuku = null;

        // COVER
        if ($request->hasFile('cover')) {

            $cover = $request
                ->file('cover')
                ->store('covers', 'public');

        }

        // EBOOK
        if ($request->hasFile('file_buku')) {

            $fileBuku = $request
                ->file('file_buku')
                ->store('ebooks', 'private');

        }

        Book::create([

            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'tipe' => $request->tipe,
            'cover' => $cover,
            'file_buku' => $fileBuku,

        ]);

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    // =========================
    // FORM EDIT
    // =========================
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    // =========================
    // UPDATE BUKU
    // =========================
    public function update(Request $request, Book $book)
    {
        $request->validate([

            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'kategori' => 'required',
            'stok' => 'required|integer',
            'tipe' => 'required',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_buku' => 'nullable|mimes:pdf|max:20480',

        ]);

        $cover = $book->cover;
        $fileBuku = $book->file_buku;

        // COVER
        if ($request->hasFile('cover')) {

            $cover = $request
                ->file('cover')
                ->store('covers', 'public');

        }

        // EBOOK
        if ($request->hasFile('file_buku')) {

            $fileBuku = $request
                ->file('file_buku')
                ->store('ebooks', 'private');

        }

        $book->update([

            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'tipe' => $request->tipe,
            'cover' => $cover,
            'file_buku' => $fileBuku,
 
        ]);

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil diperbarui');
    }

    // =========================
    // HAPUS BUKU
    // =========================
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil dihapus');
    }
}