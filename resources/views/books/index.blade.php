@extends('layouts.admin')

@section('content')

<div class="min-h-screen bg-slate-50 p-5">

    <div class="space-y-6">

        <!-- HEADER -->
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>
                <h1 class="text-3xl font-black text-slate-900">
                    Kelola Buku
                </h1>

                <p class="text-slate-500 mt-1">
                    Manajemen koleksi buku perpustakaan
                </p>
            </div>

            <a
                href="{{ route('books.create') }}"
                class="inline-flex items-center justify-center bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-2xl font-semibold shadow-sm transition"
            >
                + Tambah Buku
            </a>

        </div>

        <!-- STATS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <x-card class="p-4">
                <p class="text-slate-500 text-sm font-medium">Total Buku</p>
                <h2 class="text-3xl font-black text-slate-900 mt-3">
                    {{ $physicalBooks->total() + $digitalBooks->total() }}
                </h2>
            </x-card>

            <x-card class="p-4">
                <p class="text-slate-500 text-sm font-medium">Buku Fisik</p>
                <h2 class="text-3xl font-black text-primary-600 mt-3">
                    {{ $physicalBooks->total() }}
                </h2>
            </x-card>

            <x-card class="p-4">
                <p class="text-slate-500 text-sm font-medium">Buku Digital</p>
                <h2 class="text-3xl font-black text-violet-600 mt-3">
                    {{ $digitalBooks->total() }}
                </h2>
            </x-card>

        </div>

        <!-- LIST -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

            <!-- ===================== -->
            <!-- BUKU FISIK -->
            <!-- ===================== -->
            <x-card class="border overflow-hidden">

                <div class="px-5 py-4 border-b bg-slate-50 flex items-center justify-between">

                    <div>
                        <h2 class="text-xl font-black text-slate-900">Buku Fisik</h2>
                        <p class="text-sm text-slate-500 mt-1">Koleksi buku cetak</p>
                    </div>

                    <div class="bg-primary-100 text-primary-700 px-3 py-1 rounded-2xl text-sm font-semibold">
                        {{ $physicalBooks->total() }} Buku
                    </div>

                </div>

                <div class="p-4 space-y-3">

                    @forelse($physicalBooks as $book)

                        <x-card class="bg-slate-50 p-4 grid gap-4 sm:grid-cols-[72px_1fr_auto] sm:items-center">

                            <!-- COVER -->
                            <div class="w-16 h-24 overflow-hidden rounded-3xl bg-slate-200">

                                @if($book->cover)
                                    <img src="{{ asset('storage/' . $book->cover) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex h-full items-center justify-center text-slate-400 text-xs">
                                        No Cover
                                    </div>
                                @endif

                            </div>

                            <!-- INFO -->
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">
                                    {{ $book->judul }}
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    {{ $book->penulis }} · {{ $book->penerbit }}
                                </p>

                                <span class="inline-block mt-2 text-xs bg-slate-100 px-2 py-1 rounded-full">
                                    {{ $book->kategori }}
                                </span>

                                <span class="inline-block mt-2 text-xs bg-emerald-100 px-2 py-1 rounded-full text-emerald-700">
                                    Stok {{ $book->stok }}
                                </span>
                            </div>

                            <!-- ACTION -->
                            <div class="flex flex-col gap-2">

                                <a href="{{ route('books.edit', $book->id) }}">
                                    <x-button class="bg-amber-400 hover:bg-amber-500 text-white px-4 py-2 text-sm w-full">
                                        Edit
                                    </x-button>
                                </a>

                                <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus buku ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <x-danger-button class="w-full text-sm">
                                        Hapus
                                    </x-danger-button>
                                </form>

                            </div>

                        </x-card>

                    @empty
                        <div class="text-center py-8 text-slate-500">
                            Belum ada buku fisik
                        </div>
                    @endforelse

                </div>

                <div class="px-4 py-3 border-t bg-slate-50">
                    {{ $physicalBooks->links() }}
                </div>

            </x-card>

            <!-- ===================== -->
            <!-- BUKU DIGITAL -->
            <!-- ===================== -->
            <x-card class="border overflow-hidden">

                <div class="px-5 py-4 border-b bg-slate-50 flex items-center justify-between">

                    <div>
                        <h2 class="text-xl font-black text-slate-900">Buku Digital</h2>
                        <p class="text-sm text-slate-500 mt-1">Koleksi ebook digital</p>
                    </div>

                    <div class="bg-violet-100 text-violet-700 px-3 py-1 rounded-2xl text-sm font-semibold">
                        {{ $digitalBooks->total() }} Buku
                    </div>

                </div>

                <div class="p-4 space-y-3">

                    @forelse($digitalBooks as $book)

                        <x-card class="bg-slate-50 p-4 grid gap-4 sm:grid-cols-[72px_1fr_auto] sm:items-center">

                            <!-- COVER -->
                            <div class="w-16 h-24 overflow-hidden rounded-3xl bg-slate-200">

                                @if($book->cover)
                                    <img src="{{ asset('storage/' . $book->cover) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex h-full items-center justify-center text-slate-400 text-xs">
                                        No Cover
                                    </div>
                                @endif

                            </div>

                            <!-- INFO -->
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">
                                    {{ $book->judul }}
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    {{ $book->penulis }} · {{ $book->penerbit }}
                                </p>

                                <span class="inline-block mt-2 text-xs bg-violet-100 px-2 py-1 rounded-full text-violet-700">
                                    Ebook
                                </span>
                            </div>

                            <!-- ACTION -->
                            <div class="flex flex-col gap-2">

                                <a href="{{ route('books.edit', $book->id) }}">
                                    <x-button class="bg-amber-400 hover:bg-amber-500 text-white px-4 py-2 text-sm w-full">
                                        Edit
                                    </x-button>
                                </a>

                                <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus buku ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <x-danger-button class="w-full text-sm">
                                        Hapus
                                    </x-danger-button>
                                </form>

                            </div>

                        </x-card>

                    @empty
                        <div class="text-center py-8 text-slate-500">
                            Belum ada buku digital
                        </div>
                    @endforelse

                </div>

                <div class="px-4 py-3 border-t bg-slate-50">
                    {{ $digitalBooks->links() }}
                </div>

            </x-card>

        </div>

    </div>

</div>

@endsection