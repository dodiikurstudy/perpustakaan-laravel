<x-guest-layout>

    <div class="min-h-screen bg-gradient-to-br from-sky-50 via-slate-100 to-blue-100 flex items-center justify-center p-4">

        <div class="w-full max-w-7xl min-h-[90vh] rounded-[2rem] overflow-hidden shadow-2xl bg-white grid grid-cols-1 lg:grid-cols-2">

            <!-- LEFT -->
            <div class="flex flex-col justify-center p-8 lg:p-14 bg-white relative">

                <!-- HEADER -->
                <div class="mb-8 flex items-center gap-4">

                    <div class="w-16 h-16 rounded-[1.5rem] bg-gradient-to-br from-blue-600 to-cyan-400 flex items-center justify-center shadow-xl">

                        <span class="text-white text-2xl font-black tracking-[0.2em]">
                            DK
                        </span>

                    </div>

                    <div>

                        <p class="text-xs uppercase tracking-[.35em] text-slate-500 font-semibold">
                            Smart Digital Library
                        </p>

                        <h1 class="text-4xl font-black text-slate-900 leading-none mt-1">
                            PerpusDK
                        </h1>

                    </div>

                </div>

                <!-- CARD -->
                <div class="bg-white border border-slate-200 rounded-[2rem] shadow-xl p-8">

                    <div class="mb-8">

                        <h2 class="text-3xl font-black text-slate-900">
                            Selamat Datang 👋
                        </h2>

                        <p class="text-slate-500 mt-2 leading-relaxed">
                            Masuk untuk mengakses sistem perpustakaan digital
                            dan kelola aktivitas peminjaman buku secara realtime.
                        </p>

                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <input type="hidden" name="role" id="role" value="member">

                        <!-- ROLE -->
                        <div class="bg-slate-100 rounded-full p-1 flex items-center gap-1">

                            <button
                                type="button"
                                id="memberBtn"
                                onclick="setRole('member')"
                                class="flex-1 py-3 rounded-full bg-white shadow text-slate-900 font-bold transition"
                            >
                                Mahasiswa
                            </button>

                            <button
                                type="button"
                                id="adminBtn"
                                onclick="setRole('admin')"
                                class="flex-1 py-3 rounded-full text-slate-500 font-bold transition"
                            >
                                Admin
                            </button>

                        </div>

                        <!-- LOGIN -->
                        <div>

                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Email atau NPM
                            </label>

                            <input
                                type="text"
                                name="login"
                                value="{{ old('login') }}"
                                required
                                autofocus
                                placeholder="Masukkan email atau NPM"
                                class="w-full rounded-3xl border border-slate-300 px-5 py-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                            >

                            <x-input-error :messages="$errors->get('login')" class="mt-2" />

                        </div>

                        <!-- PASSWORD -->
                        <div>

                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Password
                            </label>

                            <div class="relative">

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    required
                                    placeholder="Masukkan password"
                                    class="w-full rounded-3xl border border-slate-300 px-5 py-4 pr-14 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                >

                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-500"
                                >

                                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.43 0 .644C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>

                                    <svg id="eyeClose" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hidden">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.477 10.488A3 3 0 0013.5 13.5"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.228 6.228C4.483 7.483 3.153 9.365 2.458 12c1.39 4.171 5.326 7.5 10.042 7.5 1.97 0 3.807-.49 5.41-1.35"/>
                                    </svg>

                                </button>

                            </div>

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />

                        </div>

                        <!-- OPTIONS -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-sm">

                            <label class="flex items-center gap-2 text-slate-600">

                                <input
                                    type="checkbox"
                                    name="remember"
                                    class="rounded border-slate-300 text-blue-600"
                                >

                                Remember me

                            </label>

                            @if (Route::has('password.request'))

                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-blue-600 hover:underline font-semibold"
                                >
                                    Forgot Password?
                                </a>

                            @endif

                        </div>

                        <!-- BUTTON -->
                        <button
                            type="submit"
                            class="w-full py-4 rounded-3xl bg-gradient-to-r from-blue-600 to-cyan-400 hover:from-blue-700 hover:to-cyan-500 text-white font-bold shadow-xl transition duration-300"
                        >
                            Sign In
                        </button>

                    </form>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="hidden lg:flex relative overflow-hidden bg-gradient-to-br from-sky-600 via-blue-700 to-slate-900 p-14 text-white items-center">

                <!-- BLUR -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>

                <div class="relative z-10 max-w-xl">

                    <div class="inline-flex items-center gap-3 bg-white/10 border border-white/20 backdrop-blur-xl px-5 py-3 rounded-3xl mb-8">

                        <div class="w-12 h-12 rounded-2xl bg-cyan-400 flex items-center justify-center text-xl shadow-lg">
                            📚
                        </div>

                        <div>

                            <p class="text-xs uppercase tracking-[.3em] text-cyan-100">
                                Digital Library
                            </p>

                            <h3 class="font-bold text-lg">
                                PerpusDK
                            </h3>

                        </div>

                    </div>

                    <h2 class="text-5xl font-black leading-tight">
                        Temukan Buku,
                        <span class="text-cyan-300">
                            Pinjam Lebih Mudah
                        </span>
                    </h2>

                    <p class="mt-6 text-lg text-sky-100 leading-relaxed">
                        Platform perpustakaan digital modern untuk mahasiswa
                        dengan sistem peminjaman cepat, realtime, dan efisien.
                    </p>

                    <!-- RUNNING TEXT -->
                    <div class="mt-10 bg-white/10 border border-white/10 backdrop-blur-xl rounded-full p-3 overflow-hidden">

                        <div class="relative h-10 overflow-hidden rounded-full bg-white/10">

                            <div
                                class="absolute inset-y-0 flex items-center whitespace-nowrap text-sm font-bold tracking-[.2em]"
                                style="animation: marquee 14s linear infinite;"
                            >
                                PERPUSDK • SMART DIGITAL LIBRARY • MODERN LIBRARY SYSTEM • PERPUSDK • SMART DIGITAL LIBRARY
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>

        function setRole(role) {

            document.getElementById('role').value = role;

            const memberBtn = document.getElementById('memberBtn');
            const adminBtn = document.getElementById('adminBtn');

            if (role === 'member') {

                memberBtn.classList.add('bg-white', 'shadow');
                memberBtn.classList.remove('text-slate-500');

                adminBtn.classList.remove('bg-white', 'shadow');
                adminBtn.classList.add('text-slate-500');

            } else {

                adminBtn.classList.add('bg-white', 'shadow');
                adminBtn.classList.remove('text-slate-500');

                memberBtn.classList.remove('bg-white', 'shadow');
                memberBtn.classList.add('text-slate-500');

            }

        }

        function togglePassword() {

            const password = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClose = document.getElementById('eyeClose');

            if (password.type === 'password') {

                password.type = 'text';

                eyeOpen.classList.add('hidden');
                eyeClose.classList.remove('hidden');

            } else {

                password.type = 'password';

                eyeOpen.classList.remove('hidden');
                eyeClose.classList.add('hidden');

            }

        }

    </script>

    <style>

        @keyframes marquee {

            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }

        }

    </style>

</x-guest-layout>