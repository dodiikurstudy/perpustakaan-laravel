@extends('layouts.admin')

@section('content')

<div class="min-h-screen bg-slate-50 p-5">
    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-black text-slate-900">Edit Buku</h1>
                <p class="text-slate-500 mt-1">Perbarui informasi buku dan file digital jika diperlukan.</p>
            </div>
        </div>

        <x-card class="p-6">
            <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="judul" value="{{ $book->judul }}" class="border p-3 rounded-lg w-full" placeholder="Judul Buku" required>
                    <input type="text" name="penulis" value="{{ $book->penulis }}" class="border p-3 rounded-lg w-full" placeholder="Penulis" required>
                    <input type="text" name="penerbit" value="{{ $book->penerbit }}" class="border p-3 rounded-lg w-full" placeholder="Penerbit" required>
                    <input type="number" name="tahun_terbit" value="{{ $book->tahun_terbit }}" class="border p-3 rounded-lg w-full" placeholder="Tahun Terbit" required>
                    <input type="text" name="kategori" value="{{ $book->kategori }}" class="border p-3 rounded-lg w-full" placeholder="Kategori" required>
                    <input type="number" name="stok" value="{{ $book->stok }}" class="border p-3 rounded-lg w-full" placeholder="Stok" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-slate-700">Tipe Buku</label>
                        <select name="tipe" id="tipeBukuEdit" class="border p-3 rounded-lg w-full mt-2">
                            <option value="fisik" {{ $book->tipe == 'fisik' ? 'selected' : '' }}>Buku Fisik</option>
                            <option value="digital" {{ $book->tipe == 'digital' ? 'selected' : '' }}>Buku Digital</option>
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-slate-700">Cover Buku</label>
                        <input type="file" name="cover" class="border p-3 rounded-lg w-full mt-2 bg-white">

                        @if($book->cover)
                            <img src="{{ asset('storage/' . $book->cover) }}" class="w-32 mt-3 rounded-2xl shadow-sm" alt="Cover {{ $book->judul }}">
                        @endif
                    </div>
                </div>

                <div id="digitalSectionEdit" class="space-y-5 border-t pt-5 {{ $book->tipe != 'digital' ? 'hidden' : '' }}">
                    <h2 class="font-semibold text-lg text-slate-900">File Digital</h2>

                    <div>
                        <label class="font-medium text-slate-700">File Ebook (PDF)</label>
                        <input type="file" name="file_buku" class="border p-3 rounded-lg w-full mt-2 bg-white">

                        @if($book->file_buku)
                            <a href="{{ asset('storage/' . $book->file_buku) }}" target="_blank" class="text-primary-600 underline text-sm block mt-2">Lihat Ebook</a>
                        @endif
                    </div>

                    <div>
                        <label class="font-medium text-slate-700">Preview Ebook (opsional)</label>
                        <input type="file" name="preview_file" class="border p-3 rounded-lg w-full mt-2 bg-white">

                        @if($book->preview_file)
                            <a href="{{ asset('storage/' . $book->preview_file) }}" target="_blank" class="text-purple-600 underline text-sm block mt-2">Lihat Preview</a>
                        @endif
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-2xl font-semibold transition">Update Buku</button>
                </div>
            </form>
        </x-card>

    </div>
</div>

<script>
    const tipeEdit = document.getElementById('tipeBukuEdit');
    const digitalSectionEdit = document.getElementById('digitalSectionEdit');

    function toggleEdit() {
        if (tipeEdit.value === 'digital') {
            digitalSectionEdit.classList.remove('hidden');
        } else {
            digitalSectionEdit.classList.add('hidden');
        }
    }

    tipeEdit.addEventListener('change', toggleEdit);
    toggleEdit();
</script>

@endsection
