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


    // Cek apakah sudah pernah mengajukan
    $exists = MemberRequest::where('user_id', $user->id)
        ->whereIn('status', [
            'pending_payment',
            'waiting_confirmation',
            'approved'
        ])
        ->exists();



    if ($exists) {

        return redirect()
            ->back()
            ->with(
                'error',
                'Anda sudah memiliki pengajuan member.'
            );

    }



    // Membuat pengajuan member baru
    MemberRequest::create([

        'user_id' => $user->id,

        // status awal pembayaran
        'status' => 'pending_payment',

        // biaya member
        'jumlah' => 50000,

    ]);



    // Arahkan ke halaman pembayaran
    return redirect()
        ->route('member.payment')
        ->with(
            'success',
            'Pengajuan member berhasil dibuat. Silakan melakukan pembayaran.'
        );
}


    public function memberPayment()
    {
        $memberRequest = MemberRequest::where('user_id', auth()->id())
            ->latest()
            ->first();

        if (!$memberRequest) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Anda belum memiliki pengajuan member.'
                );

        }

        return view(
            'user.member-payment',
            compact('memberRequest')
        );
    }

    public function uploadMemberPayment(Request $request)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|max:2048',
        ]);

        $memberRequest = MemberRequest::where('user_id', auth()->id())
            ->where('status', 'pending_payment')
            ->firstOrFail();

        $file = $request->file('bukti_pembayaran')
            ->store('member/payment', 'public');

        $memberRequest->update([
            'bukti_pembayaran' => $file,
            'tanggal_bayar' => now(),
            'status' => 'waiting_confirmation',
        ]);

        return redirect()
            ->route('member.payment')
            ->with(
                'success',
                'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.'
            );
    }

    // ======================
    // RIWAYAT & DENDA
    // ======================

    public function history()
    {
        $borrowings = Borrowing::with([
            'book',
            'payments'
        ])
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

        return view(
            'user.history',
            compact('borrowings')
        );
    }

    public function fines()
    {
        $borrowings = Borrowing::with([
            'book',
            'payments'
        ])
        ->where('user_id', auth()->id())
        ->where('denda', '>', 0)
        ->latest()
        ->get();


        $total = $borrowings->sum(function ($borrowing) {

            $paid = $borrowing->payments
                ->where('status', 'lunas')
                ->sum('jumlah');


            return max(
                $borrowing->denda - $paid,
                0
            );

        });


        return view(
            'user.fines',
            compact(
                'borrowings',
                'total'
            )
        );
    }

}