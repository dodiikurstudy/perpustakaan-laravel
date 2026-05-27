<x-app-layout>

<div class="max-w-6xl mx-auto p-6">

    <h1 class="text-2xl font-black mb-4">Favorit Saya</h1>

    @if($favorites->isEmpty())
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <p class="text-slate-500">Belum ada favorit.</p>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($favorites as $fav)
                @php $book = $fav->book; @endphp
                <x-card class="p-3 rounded-2xl border border-slate-200">
                    @if($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}" class="w-full h-44 object-cover rounded-lg mb-3">
                    @endif
                    <h3 class="font-bold text-slate-800 mb-1 line-clamp-2">{{ $book->judul }}</h3>
                    <p class="text-sm text-slate-500 mb-3">{{ $book->penulis }}</p>
                    <div class="flex gap-2">
                        <a href="{{ route('books.show', $book->id) }}" class="flex-1 text-center bg-slate-900 text-white py-2 rounded-2xl">Detail</a>
                        <form action="{{ route('favorites.destroy', $book->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="px-4 py-2 bg-slate-100 rounded-2xl">Hapus</button>
                        </form>
                    </div>
                </x-card>
            @endforeach
        </div>
    @endif

</div>

</x-app-layout>