<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-6">

        <x-card class="w-full max-w-md p-8 rounded-3xl shadow-xl">

            <h1 class="text-3xl font-bold mb-2">
                Lupa Password
            </h1>

            <p class="text-gray-500 mb-8">
                Masukkan email dan password baru.
            </p>

            <a
    href="{{ route('login') }}"
    class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 mb-6"
>

    <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="w-5 h-5"
    >

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"
        />

    </svg>

    Kembali ke Login

</a>

            @if(session('error'))

                <div class="bg-red-100 text-red-600 px-4 py-3 rounded-xl mb-5">

                    {{ session('error') }}

                </div>

            @endif

            <form method="POST" action="{{ route('password.update.custom') }}">

                @csrf

                <!-- EMAIL -->
                <div class="mb-5">

                    <label class="block mb-2 font-semibold text-gray-700">

                        Email

                    </label>

                    <input
                        type="email"
                        name="email"
                        required
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4"
                        placeholder="Masukkan email"
                    >

                </div>

                <!-- PASSWORD BARU -->
                <div class="mb-5">

                    <label class="block mb-2 font-semibold text-gray-700">

                        Password Baru

                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4"
                        placeholder="Password baru"
                    >

                </div>

                <!-- KONFIRMASI -->
                <div class="mb-6">

                    <label class="block mb-2 font-semibold text-gray-700">

                        Konfirmasi Password

                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4"
                        placeholder="Ulangi password"
                    >

                </div>

                <button
                    type="submit"
                    class="w-full bg-primary-600 hover:bg-primary-700 text-white py-4 rounded-2xl font-semibold"
                >

                    Simpan Password Baru

                </button>

            </form>

        </x-card>

    </div>

</x-guest-layout>