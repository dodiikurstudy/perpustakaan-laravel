@extends('layouts.admin')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-primary-50 p-8">

    <!-- HEADER -->
    <div class="mb-10">
        <h1 class="text-5xl font-black text-slate-800">
            Pengembalian Buku Terlambat
        </h1>
        <p class="text-slate-500 mt-3 text-lg">
            Konfirmasi pengembalian buku dan hitung denda keterlambatan
        </p>
    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-3xl p-5">
            <p class="text-emerald-700 font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-3xl p-5">
            <p class="text-red-700 font-semibold">{{ session('error') }}</p>
        </div>
    @endif

    <!-- TABLE -->
    <x-card class="p-0 overflow-hidden rounded-3xl shadow-xl border border-slate-200">

        <div class="p-6 border-b bg-slate-50">
            <h2 class="text-2xl font-black text-slate-800">
                Total: {{ $borrowings->count() }} Buku Menunggu Dikembalikan
            </h2>
        </div>

        @if($borrowings->count() > 0)

            <div class="overflow-x-auto">
                <table class="w-full">

                    <thead>
                        <tr class="bg-slate-50 border-b">
                            <th class="p-6 text-left">Nama</th>
                            <th class="p-6 text-left">Buku</th>
                            <th class="p-6 text-left">Pinjam</th>
                            <th class="p-6 text-left">Deadline</th>
                            <th class="p-6 text-center">Telat</th>
                            <th class="p-6 text-center">Denda</th>
                            <th class="p-6 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($borrowings as $borrowing)

                            @php
                                $dueDate = \Carbon\Carbon::parse($borrowing->tanggal_kembali);

                                $lateDays = now()->greaterThan($dueDate)
                                    ? now()->diffInDays($dueDate)
                                    : 0;

                                $lateDays = (int) $lateDays;
                                $calculatedFine = (int) ($lateDays * 1000);
                            @endphp

                            <tr class="border-b hover:bg-slate-50">

                                <td class="p-6">
                                    <p class="font-bold">{{ $borrowing->user->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $borrowing->user->email }}</p>
                                </td>

                                <td class="p-6 font-semibold">
                                    {{ $borrowing->book->judul }}
                                </td>

                                <td class="p-6">
                                    {{ \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y') }}
                                </td>

                                <td class="p-6 text-red-600 font-semibold">
                                    {{ $dueDate->format('d M Y') }}
                                </td>

                                <td class="p-6 text-center">
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full font-bold">
                                        {{ $lateDays }} Hari
                                    </span>
                                </td>

                                <td class="p-6 text-center font-bold">
                                    Rp {{ number_format($calculatedFine, 0, ',', '.') }}
                                </td>

                                <td class="p-6 text-center">
                                    <button
                                        onclick="document.getElementById('modal-{{ $borrowing->id }}').classList.remove('hidden')"
                                        class="bg-emerald-500 text-white px-4 py-2 rounded-xl font-bold"
                                    >
                                        Konfirmasi
                                    </button>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>

        @else

            <div class="p-20 text-center">
                <h2 class="text-2xl font-black">Tidak ada data</h2>
            </div>

        @endif

    </x-card>

</div>

<!-- MODAL -->
@foreach($borrowings as $borrowing)

    @php
        $dueDate = \Carbon\Carbon::parse($borrowing->tanggal_kembali);

        $lateDays = now()->greaterThan($dueDate)
            ? now()->diffInDays($dueDate)
            : 0;

        $lateDays = (int) $lateDays;
        $calculatedFine = (int) ($lateDays * 1000);
    @endphp

    <div id="modal-{{ $borrowing->id }}" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4">

        <x-card class="w-full max-w-md p-6">

            <h2 class="text-xl font-black mb-4">
                Konfirmasi Pengembalian
            </h2>

            <p class="text-sm text-slate-600 mb-4">
                {{ $borrowing->book->judul }} - {{ $borrowing->user->name }}
            </p>

            <form method="POST" action="{{ route('return-books.confirm', $borrowing->id) }}">
                @csrf

                <input
                    type="number"
                    name="denda"
                    value="{{ $calculatedFine }}"
                    class="w-full border p-3 rounded-xl mb-4"
                >

                <div class="flex gap-3">
                    <button class="flex-1 bg-emerald-500 text-white p-3 rounded-xl font-bold">
                        Simpan
                    </button>

                    <button type="button"
                        onclick="document.getElementById('modal-{{ $borrowing->id }}').classList.add('hidden')"
                        class="flex-1 bg-slate-200 p-3 rounded-xl font-bold">
                        Batal
                    </button>
                </div>

            </form>

        </x-card>

    </div>

@endforeach

@endsection