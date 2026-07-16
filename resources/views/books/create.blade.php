@extends('layouts.admin')

@section('content')

<div class="min-h-screen bg-slate-50 p-5">
    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-black text-slate-900">Tambah Buku</h1>
                <p class="text-slate-500 mt-1">Masukkan detail buku baru dengan lengkap.</p>
            </div>
        </div>

        <x-card class="p-6">
            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="judul" placeholder="Judul Buku" class="border p-3 rounded-lg w-full" required>
                    <input type="text" name="penulis" placeholder="Penulis" class="border p-3 rounded-lg w-full" required>
                    <input type="text" name="penerbit" placeholder="Penerbit" class="border p-3 rounded-lg w-full" required>
                    <input type="number" name="tahun_terbit" placeholder="Tahun Terbit" class="border p-3 rounded-lg w-full" required>
                    <input type="text" name="kategori" placeholder="Kategori" class="border p-3 rounded-lg w-full" required>
                    <input type="number" name="stok" placeholder="Stok Buku" class="border p-3 rounded-lg w-full" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-slate-700">Tipe Buku</label>
                        <select name="tipe" id="tipeBuku" class="border p-3 rounded-lg w-full mt-2">
                            <option value="fisik">Buku Fisik</option>
                            <option value="digital">Buku Digital</option>
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-slate-700">Upload Cover Buku</label>
                        <input type="file" name="cover" class="border p-3 rounded-lg w-full mt-2 bg-white">
                    </div>
                </div>

                <div id="digitalSection" class="space-y-5 border-t pt-5 hidden">
                    <h2 class="font-semibold text-lg text-slate-900">File Buku Digital</h2>

                    <div>
                        <label class="font-medium text-slate-700">Upload Buku Digital PDF</label>
                        <input type="file" name="file_buku" class="border p-3 rounded-lg w-full mt-2 bg-white">
                    </div>

                </div>

                <div class="pt-4">
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-2xl font-semibold transition">Simpan Buku</button>
                </div>
            </form>
        </x-card>

    </div>
</div>

<script>
    const tipeCreate = document.getElementById('tipeBuku');
    const digitalSectionCreate = document.getElementById('digitalSection');

    function toggleCreate() {
        if (tipeCreate.value === 'digital') {
            digitalSectionCreate.classList.remove('hidden');
        } else {
            digitalSectionCreate.classList.add('hidden');
        }
    }

    tipeCreate.addEventListener('change', toggleCreate);
    toggleCreate();
</script>

@endsection
