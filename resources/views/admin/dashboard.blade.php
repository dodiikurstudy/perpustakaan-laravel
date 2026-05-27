@extends('layouts.admin')

@section('content')

<div class="min-h-screen bg-slate-100 p-6">

    <div class="grid gap-6 xl:grid-cols-[1.6fr_0.95fr]">

        <div class="space-y-6">

            <div class="rounded-[32px] bg-gradient-to-r from-slate-900 via-slate-800 to-slate-700 p-8 shadow-xl overflow-hidden relative">
                <div class="absolute -right-24 -top-10 h-56 w-56 rounded-full bg-cyan-500/20 blur-3xl"></div>
                <div class="absolute -left-24 bottom-0 h-48 w-48 rounded-full bg-primary-500/10 blur-3xl"></div>
                <div class="relative z-10">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-[0.3em] text-cyan-200">Dashboard Admin</p>
                            <h1 class="mt-4 text-4xl font-black text-white">Selamat Datang, Admin</h1>
                            <p class="mt-3 max-w-2xl text-slate-200">Pantau peminjaman, denda, dan pengajuan member dari satu panel ringkas. Segera tindak lanjuti peminjaman terlambat dan permintaan baru.</p>
                        </div>
                        <div class="rounded-[28px] border border-white/10 bg-white/5 p-6 text-center shadow-lg shadow-slate-900/10 backdrop-blur">
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-300">Hari Ini</p>
                            <p class="mt-4 text-3xl font-black text-white">{{ now()->format('d M Y') }}</p>
                            <p class="mt-2 text-sm text-slate-300">{{ $totalBorrowings }} pinjaman aktif</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <x-card class="p-5">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Total Buku</p>
                    <p class="mt-4 text-3xl font-black text-slate-900">{{ $totalBooks }}</p>
                    <p class="mt-2 text-sm text-slate-500">Total koleksi tersedia</p>
                </x-card>
                <x-card class="p-5">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Total Mahasiswa</p>
                    <p class="mt-4 text-3xl font-black text-slate-900">{{ $totalUsers }}</p>
                    <p class="mt-2 text-sm text-slate-500">Akun terdaftar</p>
                </x-card>
                <x-card class="p-5">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Sedang Dipinjam</p>
                    <p class="mt-4 text-3xl font-black text-slate-900">{{ $totalBorrowings }}</p>
                    <p class="mt-2 text-sm text-slate-500">Transaksi aktif</p>
                </x-card>
                <x-card class="p-5">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Terlambat</p>
                    <p class="mt-4 text-3xl font-black text-slate-900">{{ $totalLate }}</p>
                    <p class="mt-2 text-sm text-slate-500">Perlu konfirmasi</p>
                </x-card>
                <x-card class="p-5">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Pengajuan Member</p>
                    <p class="mt-4 text-3xl font-black text-slate-900">{{ $memberRequestCount ?? 0 }}</p>
                    <p class="mt-2 text-sm text-slate-500">Menunggu persetujuan</p>
                </x-card>
                <x-card class="p-5">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Denda</p>
                    <p class="mt-4 text-3xl font-black text-slate-900">{{ $confirmedFineCount ?? 0 }}</p>
                    <p class="mt-2 text-sm text-slate-500">Item terlambat</p>
                </x-card>
            </div>
        </div>

        <div class="space-y-6">
            <x-card class="p-6">
                <div class="flex items-center justify-between gap-4 mb-5">
                    <div>
                        <p class="text-sm uppercase tracking-[0.25em] text-slate-400">Buku Terpopuler</p>
                        <h2 class="mt-2 text-2xl font-black text-slate-900">Top 5 Terlaris</h2>
                    </div>
                    <a href="{{ route('books.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-900">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @foreach($topBooks as $book)
                        <div class="flex items-center justify-between gap-4 rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $book->judul }}</p>
                                <p class="text-sm text-slate-500">{{ $book->penulis }}</p>
                            </div>
                            <span class="rounded-full bg-primary-100 px-3 py-1 text-sm font-semibold text-primary-700">{{ $book->borrowings_count }}x</span>
                        </div>
                    @endforeach
                </div>
            </x-card>

            <x-card class="p-6">
                <div class="flex items-center justify-between gap-4 mb-5">
                    <div>
                        <p class="text-sm uppercase tracking-[0.25em] text-slate-400">Pengajuan Member</p>
                        <h2 class="mt-2 text-2xl font-black text-slate-900">Tinjau permintaan</h2>
                    </div>
                    <a href="{{ route('member-requests.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-900">Lihat semua</a>
                </div>

                    @if($pendingMemberRequests->isEmpty())
                        <div class="px-6 py-12 text-center text-sm text-slate-500">
                            Tidak ada pengajuan member terkini.
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($pendingMemberRequests as $request)
                                <div class="flex items-center justify-between gap-4 rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $request->user->name }}</p>
                                        <p class="text-sm text-slate-500">{{ $request->user->npm }} · {{ $request->created_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">Menunggu</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </x-card>
        </div>
    </div>
</div>

@endsection
