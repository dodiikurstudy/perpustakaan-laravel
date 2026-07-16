<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use App\Models\MemberRequest;
use App\Models\Payment;

use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        // TOTAL
        $totalBooks = Book::count();

        $totalUsers = User::count();

        // HANYA HITUNG BUKU YANG SEDANG DIPINJAM (ACTIVE)
        $totalBorrowings = Borrowing::where('status', 'dipinjam')->count();

        // TOTAL TERLAMBAT
        $totalLate = Borrowing::where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', '<', now())
            ->count();

        // MEMBER REQUESTS (HANYA PENDING)
        $memberRequestCount = MemberRequest::where('status', 'pending')->count();

        $pendingMemberRequests = MemberRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // DENDA: HITUNG SEMUA KASUS TERLAMBAT (YANG MASIH DIPINJAM + YANG SUDAH DIKEMBALIKAN)
        $confirmedFineCount = Borrowing::where(function ($q) {
            $q->where('status', 'dipinjam')
              ->whereDate('tanggal_kembali', '<', now());
        })
        ->orWhere(function ($q) {
            $q->where('status', 'dikembalikan')
              ->where('denda', '>', 0);
        })
        ->count();

        // BUKU POPULER
        $topBooks = Book::withCount('borrowings')
            ->orderByDesc('borrowings_count')
            ->take(5)
            ->get();

        // CHART PEMINJAMAN 7 HARI TERAKHIR
        $borrowingsByDate = Borrowing::selectRaw('DATE(created_at) as date, count(*) as total')
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $weeklyChartLabels = collect(range(6, 0, -1))
            ->map(fn($days) => now()->subDays($days)->format('D'))
            ->toArray();

        $weeklyChartCounts = collect(range(6, 0, -1))
            ->map(fn($days) => $borrowingsByDate[now()->subDays($days)->format('Y-m-d')] ?? 0)
            ->toArray();

        // AKTIVITAS TERBARU
        $recentBorrowings = Borrowing::with(['user', 'book'])
            ->latest()
            ->take(3)
            ->get();

        $recentRequests = MemberRequest::with('user')
            ->latest()
            ->take(2)
            ->get();

        $recentActivities = collect()
            ->merge($recentBorrowings->map(fn($borrowing) => [
                'type' => 'borrow',
                'title' => 'Buku dipinjam',
                'description' => $borrowing->book->judul,
                'detail' => $borrowing->user->name,
                'time' => $borrowing->created_at,
                'icon' => '📘',
            ]))
            ->merge($recentRequests->map(fn($request) => [
                'type' => 'request',
                'title' => 'Permintaan member',
                'description' => $request->user->name,
                'detail' => $request->status,
                'time' => $request->created_at,
                'icon' => '📝',
            ]))
            ->sortByDesc('time')
            ->take(5)
            ->values();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalUsers',
            'totalBorrowings',
            'totalLate',
            'topBooks',
            'memberRequestCount',
            'pendingMemberRequests',
            'confirmedFineCount',
            'weeklyChartLabels',
            'weeklyChartCounts',
            'recentActivities'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | LIST USER
    |--------------------------------------------------------------------------
    */

    public function users()
    {
        $users = User::latest()->get();

        return view('admin.users', compact('users'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH USER
    |--------------------------------------------------------------------------
    */

    public function createUser()
    {
        return view('admin.create-user');
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN USER BARU
    |--------------------------------------------------------------------------
    */

    public function storeUser(Request $request)
    {
        $request->validate([

            'name' => 'required|string|max:255',

            'npm' => 'required|string|max:30|unique:users,npm',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|min:6',

            'role' => 'required|in:user,member,admin',

        ]);

        User::create([

            'name' => $request->name,

            'npm' => $request->npm,

            'email' => $request->email,

            'password' => Hash::make($request->password),

            'role' => $request->role,

        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBER REQUESTS
    |--------------------------------------------------------------------------
    */

    public function memberRequests()
{
    $requests = MemberRequest::with('user')
        ->latest()
        ->get();

    return view(
        'admin.member-requests',
        compact('requests')
    );
}


/*
|--------------------------------------------------------------------------
| APPROVE MEMBER REQUEST
|--------------------------------------------------------------------------
*/

public function approveMember(MemberRequest $memberRequest)
{
    // Pastikan user sudah mengirim bukti pembayaran
    if ($memberRequest->status != 'waiting_confirmation') {

        return redirect()
            ->back()
            ->with(
                'error',
                'User belum mengirim bukti pembayaran.'
            );

    }


    // Ubah status menjadi approved
    $memberRequest->update([

        'status' => 'approved',

    ]);


    // Upgrade role user menjadi member
    $memberRequest->user->update([

        'role' => 'member',

    ]);


    return redirect()
        ->back()
        ->with(
            'success',
            'Pembayaran berhasil diverifikasi. User sekarang menjadi member.'
        );
}


/*
|--------------------------------------------------------------------------
| REJECT MEMBER REQUEST
|--------------------------------------------------------------------------
*/

public function rejectMember(MemberRequest $memberRequest)
{
    // Pastikan hanya pembayaran yang sedang diverifikasi
    // yang dapat ditolak
    if ($memberRequest->status != 'waiting_confirmation') {

        return redirect()
            ->back()
            ->with(
                'error',
                'Pengajuan ini tidak dapat ditolak.'
            );

    }


    $memberRequest->update([

        'status' => 'rejected',

    ]);


    return redirect()
        ->back()
        ->with(
            'success',
            'Pembayaran member ditolak.'
        );
}

    /*
    |--------------------------------------------------------------------------
    | PENGEMBALIAN BUKU (TERLAMBAT)
    |--------------------------------------------------------------------------
    */

    public function pendingReturns()
    {
        $borrowings = Borrowing::with(['book', 'user'])
            ->where('status', 'menunggu_verifikasi')
            ->latest()
            ->get();

        return view('admin.return-books', compact('borrowings'));
    }

    public function confirmReturn(Borrowing $borrowing, Request $request)
    {
        $request->validate([

            'kondisi_buku' => [
                'required',
                'in:baik,rusak_ringan,rusak_berat,hilang'
            ]

        ]);


        $tambahanDenda = 0;


        if($request->kondisi_buku == 'rusak_ringan') {

            $tambahanDenda = 20000;

        }


        if($request->kondisi_buku == 'rusak_berat') {

            $tambahanDenda = 50000;

        }


        if($request->kondisi_buku == 'hilang') {

            $tambahanDenda = 100000;

        }


        $lateDays = 0;


        if(now()->gt($borrowing->tanggal_kembali))
        {
            $lateDays = $borrowing->tanggal_kembali->startOfDay()
                ->diffInDays(now()->startOfDay());
        }


        $dendaTerlambat = $lateDays * 1000;


        $totalDenda = 
        $dendaTerlambat 
        + 
        $tambahanDenda;


    $borrowing->update([

        'status' => 'dikembalikan',

        'kondisi_buku' => $request->kondisi_buku,

        'denda' => $totalDenda,

    ]);
        /*
        |--------------------------------
        | STOK BUKU
        |--------------------------------
        */

        if(
            $request->kondisi_buku == 'baik'
            ||
            $request->kondisi_buku == 'rusak_ringan'
        ){

            $borrowing->book->increment('stok');

        }


        return redirect()
            ->back()
            ->with(
                'success',
                'Pengembalian berhasil dikonfirmasi'
            );
    }



    

    /*
    |--------------------------------------------------------------------------
    | UPDATE ROLE USER
    |--------------------------------------------------------------------------
    */

    public function updateRole(Request $request, User $user)
    {
        $request->validate([

            'role' => 'required|in:user,member,admin'

        ]);

        $user->update([

            'role' => $request->role

        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Role berhasil diperbarui');
    }


    /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN DENDA
    |--------------------------------------------------------------------------
    */

    public function payments()
    {
        $payments = Payment::with([
            'user',
            'borrowing.book'
        ])
        ->where('status', 'menunggu')
        ->latest()
        ->get();

        return view(
            'admin.payments',
            compact('payments')
        );
    }

    public function confirmPayment(Payment $payment)
    {

        if($payment->status == 'lunas')
        {
            return back()->with(
                'error',
                'Pembayaran sudah dikonfirmasi.'
            );
        }


        $payment->update([
            'status' => 'lunas'
        ]);


        $borrowing = $payment->borrowing;


        $totalPaid = $borrowing->payments()
            ->where('status','lunas')
            ->sum('jumlah');


        if($totalPaid >= $borrowing->denda)
        {
            $borrowing->update([
                'denda'=>0
            ]);
        }


        return back()->with(
            'success',
            'Pembayaran berhasil dikonfirmasi.'
        );

    }

    public function destroyUser(User $user)
{
    // Mencegah admin menghapus dirinya sendiri
    if ($user->id == auth()->id()) {
        return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
    }

    $user->delete();

    return back()->with(
        'success',
        'User berhasil dihapus.'
    );
}
}