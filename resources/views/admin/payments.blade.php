@extends('layouts.admin')

@section('content')

<div class="p-10">

    <h1 class="text-4xl font-black mb-2">
        Pembayaran Denda
    </h1>

    <p class="text-slate-500 mb-8">
        Verifikasi pembayaran denda mahasiswa.
    </p>

    @if(session('success'))

        <div class="mb-6 bg-green-100 border border-green-200 text-green-700 rounded-2xl p-4">

            {{ session('success') }}

        </div>

    @endif


    @if(session('error'))

        <div class="mb-6 bg-red-100 border border-red-200 text-red-700 rounded-2xl p-4">

            {{ session('error') }}

        </div>

    @endif

    <div class="bg-white rounded-3xl shadow overflow-hidden">

        <table class="w-full">

            <thead>

                <tr class="bg-slate-100 border-b">

                    <th class="p-5 text-left">
                        Mahasiswa
                    </th>

                    <th class="p-5 text-left">
                        Buku
                    </th>

                    <th class="p-5 text-center">
                        Kondisi
                    </th>

                    <th class="p-5 text-center">
                        Jumlah
                    </th>

                    <th class="p-5 text-center">
                        Status
                    </th>

                    <th class="p-5 text-center">
                        Bukti
                    </th>

                    <th class="p-5 text-center">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($payments as $payment)

                    <tr class="border-b hover:bg-slate-50">

                        <!-- Mahasiswa -->
                        <td class="p-5">

                            <div class="font-bold">

                                {{ $payment->user->name }}

                            </div>

                            <div class="text-sm text-slate-500">

                                {{ $payment->user->email }}

                            </div>

                        </td>

                        <!-- Buku -->
                        <td class="p-5 font-semibold">

                            {{ $payment->borrowing->book->judul }}

                        </td>

                        <!-- Kondisi -->
                        <td class="p-5 text-center">

                            @switch($payment->borrowing->kondisi_buku)

                                @case('baik')

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-bold">
                                        Baik
                                    </span>

                                    @break

                                @case('rusak_ringan')

                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-bold">
                                        Rusak Ringan
                                    </span>

                                    @break

                                @case('rusak_berat')

                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-bold">
                                        Rusak Berat
                                    </span>

                                    @break

                                @case('hilang')

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-bold">
                                        Hilang
                                    </span>

                                    @break

                                @default

                                    <span class="text-slate-400">

                                        -

                                    </span>

                            @endswitch

                        </td>

                        <!-- Jumlah -->
                        <td class="p-5 text-center font-black text-red-600">

                            Rp {{ number_format($payment->jumlah,0,',','.') }}

                        </td>

                        <!-- Status -->
                        <td class="p-5 text-center">

                            @if($payment->status == 'menunggu')

                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-bold">

                                    Menunggu

                                </span>

                            @else

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-bold">

                                    Lunas

                                </span>

                            @endif

                        </td>

                        <!-- Bukti -->
                        <td class="p-5 text-center">

                           @if($payment->bukti)

    <button
        onclick="openBukti('{{ asset('storage/'.$payment->bukti) }}')"
        class="
            bg-blue-600
            hover:bg-blue-700
            text-white
            font-bold
            px-4
            py-2
            rounded-xl
            transition
        "
    >

        Lihat Bukti

    </button>

@else

    <span class="text-slate-400">
        Tidak ada
    </span>

@endif

                        </td>

                        <!-- Aksi -->
                        <td class="p-5 text-center">

                            @if($payment->status == 'menunggu')

                                <form
                                    action="{{ route('admin.payments.confirm', $payment->id) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        class="bg-red-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl font-bold transition"
                                    >

                                        Konfirmasi Lunas

                                    </button>

                                </form>

                            @else

                                <span class="text-green-600 font-bold">

                                    ✔ Sudah Lunas

                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="p-10 text-center text-slate-500"
                        >

                            Belum ada pembayaran yang menunggu konfirmasi.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div
    id="buktiModal"
    onclick="closeBukti()"
    class="
        hidden
        fixed
        inset-0
        bg-black/60
        backdrop-blur-xl
        z-50
        items-center
        justify-center
        p-6
    "
>

    <div
        class="relative"
        onclick="event.stopPropagation()"
    >

        <button
            onclick="closeBukti()"
            class="
                absolute
                -top-12
                right-0
                text-white
                text-4xl
                font-black
                hover:text-red-400
                transition
            "
        >
            ×
        </button>


        <img
            id="buktiImage"
            src=""
            class="
                max-h-[85vh]
                max-w-[90vw]
                rounded-3xl
                shadow-2xl
                object-contain
            "
        >

    </div>

</div>


<script>

function openBukti(url)
{
    const modal = document.getElementById('buktiModal');
    const image = document.getElementById('buktiImage');


    image.src = url;


    modal.classList.remove('hidden');

    modal.classList.add('flex');
}



function closeBukti()
{
    const modal = document.getElementById('buktiModal');
    const image = document.getElementById('buktiImage');


    modal.classList.add('hidden');

    modal.classList.remove('flex');


    image.src = '';
}



// Tutup dengan tombol ESC

document.addEventListener('keydown', function(event){

    if(event.key === "Escape"){

        closeBukti();

    }

});

</script>

@endsection