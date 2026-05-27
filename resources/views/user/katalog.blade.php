<x-app-layout>

<div class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-primary-50 p-5">

    <!-- FILTER -->
    <div class="bg-white/80 backdrop-blur-xl border border-white/50 rounded-[24px] shadow-lg p-4 mb-6">

        <form
            method="GET"
            action="{{ route('katalog') }}"
            class="flex flex-col xl:flex-row gap-4"
        >

            <!-- SEARCH -->
            <div class="flex-1 relative">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari judul, penulis, kategori..."
                    class="w-full bg-slate-100 border-0 rounded-2xl px-5 py-3 text-sm text-slate-700 focus:ring-2 focus:ring-primary-500"
                >

            </div>

            <!-- SWITCH -->
            <div class="flex items-center bg-slate-100 rounded-2xl p-1">

                <a
                    href="{{ route('katalog', ['tipe' => 'fisik', 'search' => request('search')]) }}"
                    class="
                        px-5 py-2 rounded-2xl text-sm font-bold transition-all duration-200
                        {{ request('tipe', 'fisik') == 'fisik'
                            ? 'bg-primary-600 text-white shadow-md'
                            : 'text-slate-600 hover:bg-white'
                        }}
                    "
                >
                    Buku Fisik
                </a>

                <a
                    href="{{ route('katalog', ['tipe' => 'digital', 'search' => request('search')]) }}"
                    class="
                        px-5 py-2 rounded-2xl text-sm font-bold transition-all duration-200
                        {{ request('tipe') == 'digital'
                            ? 'bg-violet-600 text-white shadow-md'
                            : 'text-slate-600 hover:bg-white'
                        }}
                    "
                >
                    Ebook
                </a>

            </div>

            <!-- BUTTON -->
            <button
                type="submit"
                class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-3 rounded-2xl text-sm font-bold transition"
            >
                Cari
            </button>

        </form>

    </div>

<!-- GRID -->
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-5">

    @forelse($books as $book)

        <x-card class="group overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 rounded-[26px] p-0 border border-slate-100">

            <!-- COVER -->
            <div class="relative overflow-hidden">

                @if($book->cover)

                    <img
                        src="{{ asset('storage/' . $book->cover) }}"
                        class="w-full h-[340px] object-cover object-center group-hover:scale-105 transition duration-500"
                    >

                @else

                    <div class="w-full h-[340px] bg-slate-200 flex items-center justify-center">

                        <span class="text-slate-500 text-sm">
                            Tidak ada cover
                        </span>

                    </div>

                @endif

                <!-- BADGE -->
                <div class="absolute top-3 left-3">

                    @if($book->tipe == 'digital')

                        <span class="bg-violet-600 text-white px-3 py-1 rounded-full text-xs font-black shadow-lg">
                            Ebook
                        </span>

                    @else

                        <span class="bg-primary-600 text-white px-3 py-1 rounded-full text-xs font-black shadow-lg">
                            Fisik
                        </span>

                    @endif

                </div>

            </div>

            <!-- CONTENT -->
            <div class="p-4">

                <!-- TITLE -->
                <h2 class="text-[16px] font-black text-slate-800 leading-snug line-clamp-2 min-h-[52px]">

                    {{ $book->judul }}

                </h2>

                <!-- BUTTON -->
                <div class="mt-4">
                    <a href="{{ route('books.show', $book->id) }}" class="w-full inline-flex items-center justify-center bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold px-4 py-3 rounded-2xl transition-all duration-200">Lihat Detail</a>
                </div>

            </div>

        </x-card>

    @empty

        <div class="col-span-5">

            <x-card class="p-16 text-center rounded-[30px] shadow-lg border border-slate-200">

                <h2 class="text-3xl font-black text-slate-700 mb-4">
                    Buku Tidak Ditemukan
                </h2>

                <p class="text-slate-500">
                    Coba gunakan kata kunci lain.
                </p>

            </x-card>

        </div>

    @endforelse

</div>

    <!-- PAGINATION -->
    <div class="mt-8">

        {{ $books->links() }}

    </div>

</div>

</x-app-layout>