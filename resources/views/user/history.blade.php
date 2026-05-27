<x-app-layout>

<div class="max-w-5xl mx-auto p-6">

    <h1 class="text-2xl font-black mb-4">Riwayat Peminjaman</h1>

    @if($borrowings->isEmpty())
        <div class="bg-white p-6 rounded-2xl border border-slate-200">Tidak ada riwayat.</div>
    @else
        <div class="space-y-3">
            @foreach($borrowings as $b)
                <x-card class="p-4 rounded-2xl border border-slate-200 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold">{{ $b->book->judul ?? '—' }}</h3>
                        <p class="text-sm text-slate-500">{{ $b->tanggal_pinjam }} → {{ $b->tanggal_kembali }}</p>
                    </div>
                    <div class="text-sm text-slate-700">{{ ucfirst($b->status) }}</div>
                </x-card>
            @endforeach
        </div>
    @endif

</div>

</x-app-layout>