<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PINJAM BUKU
    |--------------------------------------------------------------------------
    */

    public function store(Book $book)
    {
        // CEK STOK
        if ($book->stok < 1) {

            return back()
                ->with('error', 'Stok buku habis');

        }

        // HITUNG TOTAL BUKU YANG MASIH DIPINJAM
        $jumlahPinjam = Borrowing::where('user_id', auth()->id())
            ->where('status', 'dipinjam')
            ->count();

        // LIMIT BERDASARKAN ROLE
        $limit = auth()->user()->role == 'member'
            ? 5
            : 2;

        // CEK LIMIT
        if ($jumlahPinjam >= $limit) {

            return back()->with(

                'error',

                auth()->user()->role == 'member'
                    ? 'LIMIT_MEMBER'
                    : 'PREMIUM_MODAL'

            );

        }

        // SIMPAN PEMINJAMAN
        Borrowing::create([

            'user_id' => auth()->id(),

            'book_id' => $book->id,

            'tanggal_pinjam' => now(),

            // DEADLINE 3 HARI
            'tanggal_kembali' => now()->addDays(3),

            'status' => 'dipinjam',

            // BELUM DIPERPANJANG
            'is_extended' => false,

        ]);

        // KURANGI STOK
        $book->decrement('stok');

        return back()
            ->with('success', 'Buku berhasil dipinjam');
    }

    /*
    |--------------------------------------------------------------------------
    | PERPANJANG PEMINJAMAN
    |--------------------------------------------------------------------------
    */

public function extend(Borrowing $borrowing)
{
    // CEK PEMILIK
    if ($borrowing->user_id != auth()->id()) {

        abort(403);

    }

    $user = auth()->user();

    // USER BIASA HANYA 1 KALI
    if (
        $user->role != 'member'
        &&
        $borrowing->is_extended == 1
    ) {

        return back()->with(
            'error',
            'Peminjaman hanya dapat diperpanjang 1 kali'
        );

    }

    // UPDATE
    $borrowing->tanggal_kembali = Carbon::parse(
        $borrowing->tanggal_kembali
    )->addDays(3);

    // JIKA BUKAN MEMBER
    // TANDAI SUDAH PERPANJANG
    if ($user->role != 'member') {

        $borrowing->is_extended = 1;

    }

    $borrowing->save();

    return back()->with(
        'success',
        'Masa peminjaman berhasil diperpanjang 3 hari'
    );
}

    /*
    |--------------------------------------------------------------------------
    | KEMBALIKAN BUKU
    |--------------------------------------------------------------------------
    */

    public function returnBook(Borrowing $borrowing)
    {
        // CEK PEMILIK PEMINJAMAN
        if ($borrowing->user_id != auth()->id()) {

            abort(403);

        }

        // USER TIDAK BISA KEMBALIKAN BUKU TERLAMBAT SENDIRI
        if (now()->gt($borrowing->tanggal_kembali)) {

            return back()->with(
                'error',
                'Buku terlambat. Silakan minta admin untuk memproses pengembalian dan pembayaran denda.'
            );

        }

        $denda = 0;

        // UPDATE STATUS
        $borrowing->update([

            'status' => 'dikembalikan',

            'denda' => $denda,

        ]);

        // TAMBAH STOK BUKU
        $borrowing->book->increment('stok');

        return back()->with(
            'success',
            'Buku berhasil dikembalikan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN BUKU SAYA
    |--------------------------------------------------------------------------
    */

    public function myBooks()
    {
        $borrowings = Borrowing::with('book')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'user.my-books',
            compact('borrowings')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN PEMINJAMAN ADMIN
    |--------------------------------------------------------------------------
    */

    public function adminIndex(Request $request)
    {
        $query = Borrowing::with(['user', 'book'])
            ->latest();

        // FILTER TERLAMBAT
        if ($request->status == 'terlambat') {

            $query->where('status', 'dipinjam')
                ->whereDate('tanggal_kembali', '<', now());

        }

        $borrowings = $query->paginate(10)->withQueryString();

        return view(
            'borrowings.admin-index',
            compact('borrowings')
        );
    }
}