<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use App\Models\MemberRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ======================
    // BERANDA
    // ======================

    public function beranda()
    {
        // TOTAL
        $totalBooks = Book::count();

        $totalUsers = User::whereIn('role', ['member', 'user'])->count();

        $totalBorrowings = Borrowing::count();

        // ======================
        // BUKU TERPOPULER
        // ======================

        $topBooks = Book::withCount('borrowings')
            ->orderByDesc('borrowings_count')
            ->take(5)
            ->get();

        // ======================
        // BUKU TERBARU
        // ======================

        $latestBooks = Book::latest()
            ->take(4)
            ->get();

        // ======================
        // TOP PEMINJAM
        // HANYA USER & MEMBER
        // ======================

        $topUsers = User::whereIn('role', ['member', 'user'])
            ->withCount('borrowings')
            ->orderByDesc('borrowings_count')
            ->take(5)
            ->get();

        // ======================
        // AKTIVITAS USER LOGIN
        // ======================

        $user = auth()->user();

        // Buku yang sedang dipinjam
        $borrowedCount = Borrowing::where('user_id', $user->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        // ======================================
        // JATUH TEMPO TERDEKAT
        // ======================================

        $nearestDue = Borrowing::where('user_id', auth()->id())
        ->where('status', 'dipinjam')
        ->orderBy('tanggal_kembali', 'asc')
        ->first();

        // ======================================
        // RETURN VIEW
        // ======================================

        return view('user.beranda', compact(
        'totalBooks',
        'totalUsers',
        'totalBorrowings',
        'topBooks',
        'latestBooks',
        'topUsers',
        'borrowedCount',
        'nearestDue'
        ));

    }

    // ======================
    // KATALOG
    // ======================

    public function katalog(Request $request)
{
    $query = Book::query();

    // SEARCH
    if ($request->search) {

        $query->where(function ($q) use ($request) {

            $q->where('judul', 'like', '%' . $request->search . '%')
              ->orWhere('penulis', 'like', '%' . $request->search . '%')
              ->orWhere('penerbit', 'like', '%' . $request->search . '%')
              ->orWhere('kategori', 'like', '%' . $request->search . '%');

        });

    }

    // DEFAULT FILTER TIPE
    $tipe = $request->tipe ?? 'fisik';
    $request->merge(['tipe' => $tipe]);

    if ($tipe === 'digital') {

        $query->where('tipe', 'digital');

    } else {

        $query->where('tipe', 'fisik');

    }

    // PAGINATION
    $books = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('user.katalog', compact('books'));
}

    public function requestMember()
    {
        $user = auth()->user();

        // Cegah pengajuan ganda (pending)
        $exists = MemberRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if (! $exists) {
            MemberRequest::create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Pengajuan member berhasil dikirim.');
    }

    // ======================
    // RIWAYAT & DENDA
    // ======================

    public function history()
    {
        $borrowings = Borrowing::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.history', compact('borrowings'));
    }

    public function fines()
    {
        $borrowings = Borrowing::where('user_id', auth()->id())
            ->where('denda', '>', 0)
            ->get();

        $total = $borrowings->sum('denda');

        return view('user.fines', compact('borrowings', 'total'));
    }

}