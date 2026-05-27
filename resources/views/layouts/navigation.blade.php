<nav x-data="{ open: false }"
    class="sticky top-0 z-50 bg-white/70 backdrop-blur-xl border-b border-slate-200 shadow-sm">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- 🔥 DIBESARKAN (h-16 → h-20) -->
        <div class="flex items-center justify-between h-20">

            <!-- ================= LOGO TEXT ================= -->
            <div class="flex items-center">

                <a href="{{ auth()->user()->role == 'admin' ? route('dashboard') : route('beranda') }}"
                    class="text-2xl font-black tracking-tight text-slate-800 hover:text-primary-600 transition">

                    Perpus<span class="text-primary-600">DK</span>

                </a>

            </div>

            <!-- ================= CENTER MENU ================= -->
            @if(auth()->user()->role != 'admin')

                <div class="hidden md:flex items-center gap-3">

                    <a href="{{ route('beranda') }}"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold transition
                        {{ request()->routeIs('beranda') ? 'bg-primary-600 text-white shadow' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Beranda
                    </a>

                    <a href="{{ route('katalog') }}"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold transition
                        {{ request()->routeIs('katalog') ? 'bg-primary-600 text-white shadow' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Katalog
                    </a>

                    <a href="{{ route('my-books') }}"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold transition
                        {{ request()->routeIs('my-books') ? 'bg-primary-600 text-white shadow' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Buku Saya
                    </a>

                </div>

            @endif

            <!-- ================= RIGHT ================= -->
            <div class="flex items-center gap-4">

                <x-dropdown align="right" width="56">

                    <x-slot name="trigger">

                        <!-- 🔥 DIBESARKAN -->
                        <button class="flex items-center gap-3 bg-white border border-slate-200 px-4 py-2.5 rounded-2xl shadow-sm hover:shadow-md transition">

                            @if(Auth::user()->avatar ?? false)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                    class="w-10 h-10 rounded-xl object-cover">
                            @else
                                <div class="w-10 h-10 rounded-xl bg-slate-200 flex items-center justify-center font-bold text-slate-700">
                                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                                </div>
                            @endif

                            <div class="text-left hidden sm:block">

                                <div class="text-xs text-slate-500">
                                    Halo 👋
                                    <span class="ml-1 px-2 py-0.5 bg-primary-50 text-primary-600 rounded-full text-[10px] font-bold">
                                        {{ ucfirst(Auth::user()->role) }}
                                    </span>
                                </div>

                                <div class="text-sm font-bold text-slate-800">
                                    {{ Auth::user()->name }}
                                </div>

                            </div>

                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>

                        </button>

                    </x-slot>

                    <x-slot name="content">

                        <div class="px-4 py-3">
                            <p class="text-xs text-slate-500">Login sebagai</p>
                            <p class="font-bold text-slate-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>

                        <div class="border-t"></div>

                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('beranda')">
                            Beranda
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </x-dropdown-link>

                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

        </div>

    </div>

</nav>