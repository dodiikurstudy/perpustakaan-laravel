<x-app-layout>

<div class="max-w-5xl mx-auto p-6">

    <h1 class="text-2xl font-black mb-4">Denda</h1>

    <div class="bg-white p-6 rounded-2xl border border-slate-200">

        <p class="text-sm text-slate-600 mb-4">Total Denda: <strong>Rp {{ number_format($total ?? 0, 0, ',', '.') }}</strong></p>

        @if(!empty($borrowings) && $borrowings->isNotEmpty())
            <div class="space-y-3">
                @foreach($borrowings as $b)
                    <div class="flex justify-between items-center bg-slate-50 p-3 rounded-2xl">
                        <div>
                            <div class="font-bold">{{ $b->book->judul ?? '—' }}</div>
                            <div class="text-sm text-slate-500">Denda: Rp {{ number_format($b->denda,0,',','.') }}</div>
                        </div>
                        <div class="text-sm">Status: {{ $b->status }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-slate-500">Tidak ada denda.</p>
        @endif

    </div>

</div>

</x-app-layout>