<x-app-layout>

<div class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-blue-50 p-8">

    <div class="max-w-5xl mx-auto">


    @if(session('success'))

        <div class="
            mb-6
            bg-emerald-50
            border
            border-emerald-200
            text-emerald-700
            p-5
            rounded-3xl
            font-semibold
        ">

            {{ session('success') }}

        </div>

    @endif

        <!-- HEADER -->
        <div class="mb-8">

            <h1 class="text-4xl font-black text-slate-800">
                Denda Saya
            </h1>

            <p class="text-slate-500 mt-2">
                Kelola pembayaran denda peminjaman buku
            </p>

        </div>


        <!-- TOTAL DENDA -->
        <div class="
            bg-white
            rounded-3xl
            shadow-xl
            border
            border-slate-200
            p-8
            mb-8
        ">

            <p class="text-slate-500 font-semibold">
                Total Denda Belum Dibayar
            </p>


            <h2 class="text-5xl font-black text-red-600 mt-3">

                Rp {{ number_format($total ?? 0, 0, ',', '.') }}

            </h2>

        </div>



        <!-- LIST DENDA -->
        <div class="space-y-5">


            @forelse($borrowings as $borrowing)


                @php

                    $paid = $borrowing->payments
                        ->where('status','lunas')
                        ->sum('jumlah');


                    $remaining = max(
                        $borrowing->denda - $paid,
                        0
                    );


                    $pending = $borrowing->payments
                        ->where('status','menunggu')
                        ->count();

                @endphp



                <div class="
                    bg-white
                    rounded-3xl
                    shadow-lg
                    border
                    border-slate-200
                    p-6
                ">


                    <div class="flex flex-col md:flex-row justify-between gap-6">


                        <!-- INFO BUKU -->
                        <div>


                            <h2 class="text-2xl font-black text-slate-800">

                                {{ $borrowing->book->judul ?? '-' }}

                            </h2>


                            <p class="text-slate-500 mt-2">

                                {{ $borrowing->book->penulis ?? '-' }}

                            </p>


                            <div class="mt-5">


                                <p class="text-sm text-slate-500">
                                    Total Denda
                                </p>


                                <p class="text-3xl font-black text-red-600">

                                    Rp {{ number_format($borrowing->denda,0,',','.') }}

                                </p>


                            </div>


                        </div>



                        <!-- STATUS -->
                        <div class="flex flex-col items-start md:items-end gap-4">


                            @if($remaining <= 0)


                                <span class="
                                    bg-emerald-100
                                    text-emerald-700
                                    px-5
                                    py-2
                                    rounded-full
                                    font-black
                                ">
                                    Lunas
                                </span>



                            @elseif($pending > 0)


                                <span class="
                                    bg-yellow-100
                                    text-yellow-700
                                    px-5
                                    py-2
                                    rounded-full
                                    font-black
                                ">
                                    Menunggu Konfirmasi
                                </span>



                            @else


                                <span class="
                                    bg-red-100
                                    text-red-700
                                    px-5
                                    py-2
                                    rounded-full
                                    font-black
                                ">
                                    Belum Bayar
                                </span>



                            @endif




                            @if($remaining > 0 && $pending == 0)


                                <a
                                    href="{{ route('payments.create',$borrowing->id) }}"
                                    class="
                                        bg-blue-600
                                        hover:bg-blue-700
                                        text-white
                                        px-6
                                        py-3
                                        rounded-2xl
                                        font-black
                                        transition
                                    "
                                >

                                    Bayar Sekarang

                                </a>


                            @endif


                        </div>


                    </div>


                </div>


            @empty


                <div class="
                    bg-white
                    rounded-3xl
                    shadow-lg
                    p-10
                    text-center
                ">


                    <h2 class="text-2xl font-black text-slate-700">

                        Tidak Ada Denda

                    </h2>


                    <p class="text-slate-500 mt-2">

                        Kamu tidak memiliki tagihan denda.

                    </p>


                </div>


            @endforelse


        </div>


    </div>

    

</div>

</x-app-layout>