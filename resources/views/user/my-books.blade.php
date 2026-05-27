<x-app-layout>

    <div class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-blue-50 p-8">

        <!-- HEADER -->
        <div class="mb-10">

            <h1 class="text-5xl font-black text-slate-800">
                Buku Saya
            </h1>

            <p class="text-slate-500 mt-3 text-lg">
                Pantau status peminjaman dan denda buku kamu
            </p>

        </div>

        <!-- LIST -->
        <div class="space-y-6">

            @forelse($borrowings as $borrowing)

                @php

                    $isLate =
                        $borrowing->status == 'dipinjam'
                        &&
                        now()->gt($borrowing->tanggal_kembali);

                    $lateDays = $isLate
                        ? abs((int) now()->diffInDays($borrowing->tanggal_kembali))
                        : 0;

                    $calculatedFine = $isLate
                        ? $lateDays * 1000
                        : 0;

                @endphp

                <div class="bg-white rounded-[32px] shadow-xl border border-slate-100 overflow-hidden">

                    <!-- TOP BORDER -->
                    <div class="
                        h-2
                        {{ $isLate
                            ? 'bg-gradient-to-r from-red-500 to-orange-500'
                            : 'bg-gradient-to-r from-blue-500 to-indigo-500'
                        }}
                    "></div>

                    <div class="p-8">

                        <div class="flex flex-col xl:flex-row gap-8 justify-between">

                            <!-- LEFT -->
                            <div class="flex gap-6">

                                <!-- COVER -->
                                <div class="shrink-0">

                                    @if($borrowing->book->cover)

                                        <img
                                            src="{{ asset('storage/' . $borrowing->book->cover) }}"
                                            class="w-36 h-52 object-cover rounded-3xl shadow-xl"
                                        >

                                    @else

                                        <div class="w-36 h-52 bg-slate-200 rounded-3xl flex items-center justify-center">

                                            <span class="text-slate-500 text-sm">
                                                No Cover
                                            </span>

                                        </div>

                                    @endif

                                </div>

                                <!-- INFO -->
                                <div class="flex-1">

                                    <!-- TITLE -->
                                    <h2 class="text-4xl font-black text-slate-800 leading-tight">

                                        {{ $borrowing->book->judul }}

                                    </h2>

                                    <!-- AUTHOR -->
                                    <p class="text-slate-500 text-xl mt-3">

                                        {{ $borrowing->book->penulis }}

                                    </p>

                                    <!-- STATUS -->
                                    <div class="flex flex-wrap gap-3 mt-6">

                                        @if($borrowing->status == 'dipinjam')

                                            <span class="bg-amber-100 text-amber-700 px-5 py-2 rounded-full text-sm font-black">
                                                Sedang Dipinjam
                                            </span>

                                        @endif

                                        @if($borrowing->status == 'dikembalikan')

                                            <span class="bg-emerald-100 text-emerald-700 px-5 py-2 rounded-full text-sm font-black">
                                                Sudah Dikembalikan
                                            </span>

                                        @endif

                                        @if($isLate)

                                            <span class="bg-red-100 text-red-600 px-5 py-2 rounded-full text-sm font-black animate-pulse">
                                                Terlambat {{ $lateDays }} Hari
                                            </span>

                                        @endif

                                    </div>

                                    <!-- INFO GRID -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-8">

                                        <!-- PINJAM -->
                                        <div class="bg-slate-50 rounded-3xl p-5 border border-slate-100">

                                            <p class="text-slate-400 text-sm font-semibold uppercase tracking-wide">
                                                Tanggal Pinjam
                                            </p>

                                            <h3 class="text-2xl font-black text-slate-800 mt-2">

                                                {{ \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y') }}

                                            </h3>

                                        </div>

                                        <!-- DEADLINE -->
                                        <div class="
                                            rounded-3xl p-5 border
                                            {{ $isLate
                                                ? 'bg-red-50 border-red-100'
                                                : 'bg-slate-50 border-slate-100'
                                            }}
                                        ">

                                            <p class="
                                                text-sm font-semibold uppercase tracking-wide
                                                {{ $isLate ? 'text-red-400' : 'text-slate-400' }}
                                            ">
                                                Deadline
                                            </p>

                                            <h3 class="
                                                text-2xl font-black mt-2
                                                {{ $isLate ? 'text-red-600' : 'text-slate-800' }}
                                            ">

                                                {{ \Carbon\Carbon::parse($borrowing->tanggal_kembali)->format('d M Y') }}

                                            </h3>

                                        </div>

                                        <!-- DENDA -->
                                        <div class="
                                            rounded-3xl p-5 border
                                            {{ $calculatedFine > 0
                                                ? 'bg-gradient-to-br from-red-50 to-orange-50 border-red-200'
                                                : 'bg-slate-50 border-slate-100'
                                            }}
                                        ">

                                            <p class="
                                                text-sm font-semibold uppercase tracking-wide
                                                {{ $calculatedFine > 0
                                                    ? 'text-red-400'
                                                    : 'text-slate-400'
                                                }}
                                            ">
                                                Denda
                                            </p>

                                            <h3 class="
                                                text-3xl font-black mt-2
                                                {{ $calculatedFine > 0
                                                    ? 'text-red-600'
                                                    : 'text-emerald-600'
                                                }}
                                            ">

                                                Rp {{ number_format($calculatedFine, 0, ',', '.') }}

                                            </h3>

                                            @if($calculatedFine > 0)

                                                <p class="text-red-500 text-sm mt-2 font-semibold">
                                                    Rp 1.000 / hari keterlambatan
                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- RIGHT -->
                            @if($borrowing->status == 'dipinjam')

                                <div class="flex flex-col gap-4 min-w-[260px]">

                                    <!-- EXTEND -->
                                    @if(!$borrowing->is_extended)

                                        <form
                                            action="{{ route('borrowings.extend', $borrowing->id) }}"
                                            method="POST"
                                        >

                                            @csrf

                                            <button
                                                class="
                                                    w-full
                                                    bg-blue-600 hover:bg-blue-700
                                                    text-white
                                                    py-4 px-6
                                                    rounded-3xl
                                                    font-black
                                                    text-lg
                                                    transition-all duration-200
                                                    shadow-lg hover:shadow-xl
                                                "
                                            >

                                                Perpanjang 3 Hari

                                            </button>

                                        </form>

                                    @endif

                                    <!-- RETURN -->
                                    @if(!$isLate)

                                        <form
                                            action="{{ route('borrowings.return', $borrowing->id) }}"
                                            method="POST"
                                        >

                                            @csrf

                                            <button
                                                class="
                                                    w-full
                                                    bg-red-500 hover:bg-red-600
                                                    text-white
                                                    py-4 px-6
                                                    rounded-3xl
                                                    font-black
                                                    text-lg
                                                    transition-all duration-200
                                                    shadow-lg hover:shadow-xl
                                                "
                                            >

                                                Kembalikan Buku

                                            </button>

                                        </form>

                                    @else

                                        <div class="bg-red-50 border border-red-200 rounded-3xl p-6 text-center">


                                            <h3 class="text-red-600 text-xl font-black">
                                                Menunggu Konfirmasi Admin
                                            </h3>

                                            <p class="text-red-500 mt-3 text-sm leading-relaxed">
                                                Buku terlambat dikembalikan.
                                                Silakan hubungi admin untuk proses pengembalian dan pembayaran denda.
                                            </p>

                                        </div>

                                    @endif

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            @empty

                <div class="bg-white rounded-[32px] shadow-xl border border-slate-100 p-20 text-center">

                    <h2 class="text-4xl font-black text-slate-700 mb-4">
                        Belum Ada Buku
                    </h2>

                    <p class="text-slate-500 text-lg">
                        Kamu belum meminjam buku apapun.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</x-app-layout>
