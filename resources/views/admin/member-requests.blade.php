@extends('layouts.admin')

@section('content')

<div class="min-h-screen bg-slate-100 p-8">

    <!-- HEADER -->
    <div class="mb-8 flex items-center justify-between">

        <div>
            <h1 class="text-4xl font-black text-slate-800">
                Pengajuan Member
            </h1>

            <p class="text-slate-500 mt-2">
                Kelola permintaan upgrade member dari pengguna
            </p>
        </div>

        <a
            href="{{ route('dashboard') }}"
            class="bg-white text-slate-800 font-bold px-6 py-3 rounded-2xl border border-slate-200 hover:shadow-lg transition"
        >
            Kembali
        </a>

    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-2xl p-4">
            <p class="text-emerald-700 font-semibold">
                {{ session('success') }}
            </p>
        </div>
    @endif

    <!-- CARD -->
    <x-card class="p-0 overflow-hidden">

        <!-- HEADER TABLE -->
        <div class="px-6 py-6 border-b border-slate-200">
            <h2 class="text-2xl font-black text-slate-800">
                Permintaan Tertunda
            </h2>

            <p class="text-slate-500 mt-1">
                {{ $requests->where('status', 'waiting_confirmation')->count() }}
                pembayaran menunggu verifikasi
            </p>
        </div>

        <!-- EMPTY -->
        @if($requests->isEmpty())

            <div class="px-6 py-16 text-center">
                <p class="text-slate-500 text-lg">
                    Tidak ada pengajuan member
                </p>
            </div>

        @else

            <!-- TABLE -->
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50">
                        <tr>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-600">
                                Nama
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-600">
                                Email
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-600">
                                NPM
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-600">
                                Status
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-600">
                                Tanggal
                            </th>

                            <th class="px-6 py-4 text-center text-sm font-bold text-slate-600">
                                Bukti
                            </th>

                            <th class="px-6 py-4 text-center text-sm font-bold text-slate-600">
                                Aksi
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach($requests as $req)

                            <tr class="border-t border-slate-200 hover:bg-slate-50 transition">

                                <!-- NAME -->
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ $req->user->name }}
                                </td>

                                <!-- EMAIL -->
                                <td class="px-6 py-4 text-slate-600 text-sm">
                                    {{ $req->user->email }}
                                </td>

                                <!-- NPM -->
                                <td class="px-6 py-4 text-slate-600 text-sm">
                                    {{ $req->user->npm }}
                                </td>

                                <!-- STATUS -->
                                <td class="px-6 py-4">

                                    @if($req->status === 'pending_payment')

                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full">
                                            Menunggu Pembayaran
                                        </span>

                                    @elseif($req->status === 'waiting_confirmation')

                                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full">
                                            Menunggu Verifikasi
                                        </span>

                                    @elseif($req->status === 'approved')

                                        <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">
                                            Member Aktif
                                        </span>

                                    @elseif($req->status === 'rejected')

                                        <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full">
                                            Ditolak
                                        </span>

                                    @endif

                                </td>

                                <!-- DATE -->
                                <td class="px-6 py-4 text-slate-600 text-sm">
                                    {{ $req->created_at->format('d M Y H:i') }}
                                </td>
                                
                                <!-- BUKTI PEMBAYARAN -->
<td class="px-6 py-4 text-center">

    @if($req->bukti_pembayaran)

        <button
            onclick="openBukti('{{ asset('storage/'.$req->bukti_pembayaran) }}')"
            class="
                bg-blue-600
                hover:bg-blue-700
                text-white
                px-4
                py-2
                rounded-xl
                font-bold
                transition
            "
        >

            Lihat Bukti

        </button>

    @else

        <span class="text-slate-400 text-sm">
            Belum Upload
        </span>

    @endif

</td>

                                <!-- ACTION -->
                                <td class="px-6 py-4 text-center">

                                    @if($req->status === 'waiting_confirmation')

                                        <div class="flex gap-2 justify-center">

                                            <form action="{{ route('member-requests.approve', $req) }}" method="POST">
                                                @csrf
                                                <x-button class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 text-sm">
                                                    Setuju
                                                </x-button>
                                            </form>

                                            <form action="{{ route('member-requests.reject', $req) }}" method="POST">
                                                @csrf
                                                <x-danger-button class="px-4 py-2 text-sm">
                                                    Tolak
                                                </x-danger-button>
                                            </form>

                                        </div>

                                    @else
                                        <span class="text-slate-400 text-sm">—</span>
                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </x-card>

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
                max-h-[95vh]
                max-w-[95vw]
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

document.addEventListener('keydown', function(event){

    if(event.key === 'Escape'){

        closeBukti();

    }

});

</script>

@endsection