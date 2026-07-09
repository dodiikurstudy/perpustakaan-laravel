<nav class="sticky top-0 z-50 bg-white/70 backdrop-blur-xl border-b border-slate-200 shadow-sm">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between h-20">

            <!-- LOGO -->
            <a
                href="{{ route('katalog') }}"
                class="text-2xl font-black tracking-tight text-slate-800 hover:text-primary-600 transition"
            >
                Perpus<span class="text-primary-600">DK</span>
            </a>

            <!-- MENU -->
            <div class="flex items-center gap-3">

                <a
                    href="{{ route('katalog') }}"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold transition
                    {{ request()->routeIs('katalog') ? 'bg-primary-600 text-white shadow' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}"
                >
                    Katalog
                </a>

            </div>

            <!-- AUTH -->
            <div class="flex items-center gap-3">

                <a
                    href="{{ route('login') }}"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition"
                >
                    Masuk
                </a>

                <a
                    href="{{ route('register') }}"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold bg-primary-600 text-white hover:bg-primary-700 transition"
                >
                    Daftar
                </a>

            </div>

        </div>

    </div>

</nav>