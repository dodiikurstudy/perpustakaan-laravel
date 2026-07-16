<x-app-layout>

<div class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-primary-50 p-5">

    <div class="max-w-7xl mx-auto">

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

            <!-- ================= DETAIL BUKU ================= -->
            <div class="xl:col-span-2">

                <x-card class="bg-white/80 backdrop-blur-xl border border-white/50 rounded-[28px] shadow-lg overflow-hidden p-0">

                    <div class="grid md:grid-cols-2">

                        <!-- COVER (FIX: tidak terlalu tinggi lagi) -->
                        <div class="relative bg-slate-100">

                            @if($book->cover)

                                <img
                                    src="{{ asset('storage/' . $book->cover) }}"
                                    class="w-full h-full object-cover max-h-[520px]"
                                >

                            @else

                                <div class="w-full h-[520px] flex items-center justify-center">
                                    <span class="text-slate-500">Tidak ada cover</span>
                                </div>

                            @endif

                            <!-- BADGE -->
                            <div class="absolute top-4 left-4">

                                @if($book->tipe == 'digital')
                                    <span class="bg-violet-600 text-white px-4 py-1.5 rounded-full text-xs font-black shadow">
                                        Ebook
                                    </span>
                                @else
                                    <span class="bg-primary-600 text-white px-4 py-1.5 rounded-full text-xs font-black shadow">
                                        Buku Fisik
                                    </span>
                                @endif

                            </div>

                        </div>

                        <!-- CONTENT (dibuat lebih compact) -->
                        <div class="p-6 flex flex-col">

                            <!-- TITLE -->
                            <div>

                                <h1 class="text-3xl font-black text-slate-800 leading-tight">
                                    {{ $book->judul }}
                                </h1>

                                <p class="text-slate-500 text-sm mt-2">
                                    Temukan pengalaman membaca terbaik dari perpustakaan digital.
                                </p>

                            </div>

                            <!-- INFO GRID (lebih ringkas) -->
                            <div class="mt-5 space-y-3">

                                <div class="bg-slate-100 rounded-xl p-3">
                                    <p class="text-xs text-slate-400">Penulis</p>
                                    <p class="font-bold text-slate-800">{{ $book->penulis }}</p>
                                </div>

                                <div class="bg-slate-100 rounded-xl p-3">
                                    <p class="text-xs text-slate-400">Penerbit</p>
                                    <p class="font-bold text-slate-800">{{ $book->penerbit }}</p>
                                </div>

                                <div class="grid grid-cols-2 gap-3">

                                    <div class="bg-slate-100 rounded-xl p-3">
                                        <p class="text-xs text-slate-400">Kategori</p>
                                        <p class="font-bold text-slate-800 text-sm">{{ $book->kategori }}</p>
                                    </div>

                                    <div class="bg-slate-100 rounded-xl p-3 text-center">
                                        <p class="text-xs text-slate-400">Stok</p>
                                        <p class="text-2xl font-black text-emerald-600">{{ $book->stok }}</p>
                                    </div>

                                </div>

                            </div>

                            <!-- ACTION -->
                            <div class="mt-5 space-y-3">

                                @php
                                    $isFav = auth()->user() && auth()->user()->favorites()->where('book_id', $book->id)->exists();
                                @endphp

                                @auth

                                    @if($isFav)

                                        <form action="{{ route('favorites.destroy', $book->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <x-danger-button class="w-full">
                                                Hapus Favorit
                                            </x-danger-button>

                                        </form>

                                    @else

                                        <form action="{{ route('favorites.store', $book->id) }}" method="POST">
                                            @csrf

                                            <x-button class="w-full bg-pink-500 text-white">
                                                Tambah Favorit
                                            </x-button>

                                        </form>

                                    @endif

                                @endauth

                                @guest

                                    <a
                                        href="{{ route('login') }}"
                                        class="block w-full text-center bg-pink-500 text-white font-black py-3 rounded-2xl"
                                    >
                                        Masuk untuk Menambahkan Favorit
                                    </a>

                                @endguest

                                @if($book->tipe == 'fisik')

                                    @auth

                                    <form action="{{ route('borrowings.store',$book->id) }}" method="POST">
                                        @csrf

                                        <button class="block w-full text-center bg-red-500 text-white font-black py-3 rounded-2xl">
                                            Pinjam Buku
                                        </button>

                                    </form>

                                    @endauth

                                    @guest

                                    <a
                                        href="{{ route('login') }}"
                                        class="block w-full text-center bg-emerald-600 text-white font-black py-3 rounded-2xl"
                                    >
                                        Masuk untuk Meminjam
                                    </a>

                                    @endguest

                                @else

                                    @auth

                                        @if(auth()->user()->role == 'admin')

                                            <button
                                                type="button"
                                                disabled
                                                class="block w-full text-center bg-slate-400 text-white font-black py-3 rounded-2xl cursor-not-allowed"
                                            >
                                                Admin Tidak Dapat Membaca Ebook
                                            </button>

                                        @else

                                            <a
                                                href="{{ route('ebooks.read', $book) }}"
                                                class="block text-center w-full bg-violet-600 hover:bg-violet-700 text-white font-black py-3 rounded-2xl transition"
                                            >
                                                @if($progress && $progress->last_page > 1)

                                                    Lanjutkan Baca

                                                @else

                                                    Baca Ebook

                                                @endif

                                            </a>

                                            @if($progress && $progress->last_page > 1)

                                                <p class="text-sm text-gray-500 mt-2 text-center">

                                                    Terakhir dibaca:
                                                    halaman {{ $progress->last_page }}

                                                </p>

                                            @endif

                                        @endif

                                    @endauth

                                    @guest

                                        <a
                                            href="{{ route('login') }}"
                                            class="block text-center w-full bg-violet-600 text-white font-black py-3 rounded-2xl"
                                        >
                                            Masuk untuk Membaca Ebook
                                        </a>

                                    @endguest

                                @endif

                            </div>

                        </div>

                    </div>

                </x-card>

            </div>

            <!-- ================= REVIEW (FIX SCROLL BIAR GAK PANJANG) ================= -->
            <div>

                <x-card class="bg-white/80 backdrop-blur-xl border border-white/50 rounded-[28px] shadow-lg p-6 sticky top-5">

                    <h2 class="text-2xl font-black">Review</h2>
                    <p class="text-slate-500 text-sm mb-4">Bagikan pengalamanmu</p>

                    @auth

    <!-- FORM KOMENTAR -->
    <form action="{{ route('comments.store', $book->id) }}" method="POST" class="space-y-3 mb-5">

        @csrf

        <select name="rating" class="w-full bg-slate-100 rounded-xl p-3">
            <option value="5">⭐⭐⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="2">⭐⭐</option>
            <option value="1">⭐</option>
        </select>

        <textarea
            name="isi"
            rows="3"
            class="w-full bg-slate-100 rounded-xl p-3"
            placeholder="Tulis review..."
        ></textarea>

        <x-button class="w-full bg-slate-900 text-white">
            Kirim
        </x-button>

    </form>

@endauth

@guest

    <a
        href="{{ route('login') }}"
        class="block w-full text-center bg-slate-900 text-white font-bold py-3 rounded-xl hover:bg-slate-800 transition"
    >
        Masuk untuk Memberikan Komentar
    </a>

@endguest

                    <!-- REVIEW LIST (INI YANG BIKIN TIDAK FULL SCROLL) -->
                    <div class="space-y-3 max-h-[420px] overflow-y-auto pr-1">

                        @forelse($book->comments as $comment)

                            <div class="bg-slate-100 rounded-xl p-3">

                                <div class="flex justify-between items-center mb-1">
                                    <p class="font-bold text-sm">{{ $comment->user->name }}</p>
                                    <span class="text-yellow-500 text-sm">
                                        {{ str_repeat('⭐', $comment->rating) }}
                                    </span>
                                </div>

                                <p class="text-xs text-slate-600">
                                    {{ $comment->isi }}
                                </p>

                            </div>

                        @empty

                            <p class="text-center text-slate-500 text-sm">
                                Belum ada review
                            </p>

                        @endforelse

                    </div>

                </x-card>

            </div>

        </div>

    </div>

</div>

</x-app-layout>