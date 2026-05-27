@extends('layouts.admin')

@section('content')

<div class="p-10">

    <x-card class="p-8 rounded-2xl shadow">

        <h1 class="text-3xl font-bold mb-8">
            Data Peminjaman Buku
        </h1>

        <!-- FILTER -->
        <div class="mb-6 flex gap-3">

            <a
                href="{{ route('borrowings.admin') }}"
                class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded-xl transition"
            >

                Semua

            </a>

            <a
                href="{{ route('borrowings.admin', ['status' => 'terlambat']) }}"
                class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl transition"
            >

                Terlambat

            </a>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead>

                    <tr class="border-b bg-gray-50">

                        <th class="p-4 text-left">
                            Mahasiswa
                        </th>

                        <th class="p-4 text-left">
                            Buku
                        </th>

                        <th class="p-4 text-left">
                            Tanggal Pinjam
                        </th>

                        <th class="p-4 text-left">
                            Deadline
                        </th>

                        <th class="p-4 text-left">
                            Status
                        </th>

                        <th class="p-4 text-left">
                            Denda
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($borrowings as $borrowing)

                        @php

                            $terlambat =
                                $borrowing->status == 'dipinjam'
                                &&
                                $borrowing->tanggal_kembali
                                &&
                                now()->gt($borrowing->tanggal_kembali);

                        @endphp

                        <tr class="border-b hover:bg-gray-50">

                            <!-- MAHASISWA -->
                            <td class="p-4">

                                {{ $borrowing->user->name }}

                            </td>

                            <!-- BUKU -->
                            <td class="p-4">

                                {{ $borrowing->book->judul }}

                            </td>

                            <!-- TANGGAL PINJAM -->
                            <td class="p-4">

                                {{ \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y') }}

                            </td>

                            <!-- DEADLINE -->
                            <td class="p-4">

                                {{ \Carbon\Carbon::parse($borrowing->tanggal_kembali)->format('d M Y') }}

                            </td>

                            <!-- STATUS -->
                            <td class="p-4">

                                @if($terlambat)

                                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold">

                                        Terlambat

                                    </span>

                                @elseif($borrowing->status == 'dipinjam')

                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">

                                        Dipinjam

                                    </span>

                                @else

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">

                                        Dikembalikan

                                    </span>

                                @endif

                            </td>

                            <!-- DENDA -->
                            <td class="p-4">

                                @if($borrowing->denda > 0)

                                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">

                                        Rp {{ number_format($borrowing->denda, 0, ',', '.') }}

                                    </span>

                                @else

                                    <span class="text-gray-400">

                                        -

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

            <div class="mt-6 px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                {{ $borrowings->links() }}
            </div>

        </div>

    </x-card>

</div>

@endsection