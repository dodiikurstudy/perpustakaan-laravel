<x-app-layout>

<div class="min-h-screen bg-slate-100 py-10 px-4">

    <div class="max-w-xl mx-auto bg-white rounded-3xl shadow-xl p-8">

        <h1 class="text-3xl font-black mb-6">
            Pembayaran Denda
        </h1>

        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200">

            <h2 class="text-xl font-bold">
                {{ $borrowing->book->judul }}
            </h2>

            <div class="mt-4">
                <p class="text-slate-500">
                    Total Denda
                </p>

                <h3 class="text-4xl font-black text-red-600 mt-1">
                    Rp {{ number_format($borrowing->denda, 0, ',', '.') }}
                </h3>
            </div>

        </div>

        {{-- INFORMASI PEMBAYARAN --}}
            <div class="mb-5">

                <p class="font-semibold">
                    Silakan transfer ke:
                </p>


                <p>
                    Bank BCA
                </p>


                <p>
                    1234567890
                </p>


                <p>
                    a.n Perpustakaan DK
                </p>

            </div>

        <form
            method="POST"
            action="{{ route('payments.store', $borrowing->id) }}"
            enctype="multipart/form-data"
            class="mt-8 space-y-5"
        >
            @csrf

            <div>
                <label class="block font-bold mb-2">
                    Upload Bukti Pembayaran
                </label>

                <input
                    type="file"
                    name="bukti"
                    class="w-full border border-slate-300 rounded-xl p-3"
                    accept="image/*"
                    required
                >

                <p class="text-sm text-slate-500 mt-2">
                    Upload bukti pembayaran dalam format JPG, JPEG, atau PNG.
                </p>
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition"
            >
                Kirim Bukti Pembayaran
            </button>

        </form>

    </div>

</div>

</x-app-layout>