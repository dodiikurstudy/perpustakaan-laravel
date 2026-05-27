<x-app-layout>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-primary-50 to-slate-50">

        <div class="max-w-[1600px] mx-auto px-4 md:px-6 lg:px-8 py-8">

            <!-- HERO -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8 mb-8">

                <!-- LEFT HERO -->
                <div class="xl:col-span-2 bg-gradient-to-br from-primary-600 via-primary-600 to-primary-700 rounded-2xl lg:rounded-3xl p-8 lg:p-10 shadow-2xl overflow-hidden relative">

                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-10"></div>
                    <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-primary-400/10 rounded-full blur-3xl"></div>

                    <div class="relative z-10">

                        <div class="mb-2">
                            <p class="text-primary-100 text-sm font-semibold uppercase tracking-wide">Selamat Datang Kembali</p>
                        </div>

                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight mb-4">

                            Halo, {{ auth()->user()->name }}! 👋

                        </h1>

                        <p class="text-primary-100 text-base lg:text-lg mb-8 max-w-2xl">

                            Jelajahi koleksi buku kami yang lengkap dan temukan bacaan seru untuk menemani harimu.

                        </p>

                        <!-- SEARCH -->
                        <form
                            action="{{ route('katalog') }}"
                            method="GET"
                            class="flex items-center bg-white/95 backdrop-blur rounded-xl overflow-hidden shadow-lg max-w-2xl mb-6 hover:shadow-xl transition-shadow duration-300"
                        >

                            <svg class="w-5 h-5 ml-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>

                            <input
                                type="text"
                                name="search"
                                placeholder="Cari judul buku, penulis, ISBN..."
                                class="w-full px-4 py-3 border-0 focus:ring-0 text-slate-700 bg-transparent placeholder-slate-400"
                            >

                            <button
                                type="submit"
                                class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 font-semibold transition-colors duration-200"
                            >

                                Cari

                            </button>

                        </form>

                        <a
                            href="{{ route('katalog') }}"
                            class="inline-flex items-center gap-2 mt-3 text-white font-semibold hover:text-primary-100 transition-colors duration-200"
                        >

                            <span>Jelajahi Katalog Lengkap</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>

                        </a>

                        <!-- QUICK MENU MEMANJANG -->
                        <div class="mt-10 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">

                            <a
                                href="{{ route('my-books') }}"
                                class="group bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 rounded-xl p-4 flex flex-col items-center justify-center text-center gap-2 transition-all duration-300 hover:scale-105"
                            >

                                <div class="text-2xl">📚</div>

                                <div class="text-white">

                                    <p class="font-semibold text-xs">
                                        Buku Saya
                                    </p>

                                </div>

                            </a>

                            <a
                                href="{{ route('katalog') }}"
                                class="group bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 rounded-xl p-4 flex flex-col items-center justify-center text-center gap-2 transition-all duration-300 hover:scale-105"
                            >

                                <div class="text-2xl">🔎</div>

                                <div class="text-white">

                                    <p class="font-semibold text-xs">
                                        Katalog
                                    </p>

                                </div>

                            </a>

                            <a
                                href="#"
                                class="group bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 rounded-xl p-4 flex flex-col items-center justify-center text-center gap-2 transition-all duration-300 hover:scale-105"
                            >

                                <div class="text-2xl">❤️</div>

                                <div class="text-white">

                                    <p class="font-semibold text-xs">
                                        Favorit
                                    </p>

                                </div>

                            </a>

                            <a
                                href="#"
                                class="group bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 rounded-xl p-4 flex flex-col items-center justify-center text-center gap-2 transition-all duration-300 hover:scale-105"
                            >

                                <div class="text-2xl">🕒</div>

                                <div class="text-white">

                                    <p class="font-semibold text-xs">
                                        Riwayat
                                    </p>

                                </div>

                            </a>

                            <a
                                href="#"
                                class="group bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 rounded-xl p-4 flex flex-col items-center justify-center text-center gap-2 transition-all duration-300 hover:scale-105"
                            >

                                <div class="text-2xl">💰</div>

                                <div class="text-white">

                                    <p class="font-semibold text-xs">
                                        Denda
                                    </p>

                                </div>

                            </a>

                            <a
                                href="{{ route('profile.edit') }}"
                                class="group bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 rounded-xl p-4 flex flex-col items-center justify-center text-center gap-2 transition-all duration-300 hover:scale-105"
                            >

                                <div class="text-2xl">👤</div>

                                <div class="text-white">

                                    <p class="font-semibold text-xs">
                                        Profil
                                    </p>

                                </div>

                            </a>

                        </div>

                    </div>

                </div>

                <!-- CHART BUKU TERPOPULER -->
                <x-card class="p-6 lg:p-8 shadow-md border border-slate-100 hover:shadow-xl transition-shadow duration-300">

                    <div class="mb-8">

                        <h2 class="text-2xl font-bold text-slate-900">

                            📊 Buku Terpopuler

                        </h2>

                        <p class="text-slate-600 text-sm mt-2 font-medium">

                            Berdasarkan total peminjaman

                        </p>

                    </div>

                    <!-- DIAGRAM LINGKARAN -->
                    <div class="flex justify-center mb-10">

                        <div class="relative w-56 h-56 sm:w-64 sm:h-64">

                            <div
                                class="w-full h-full rounded-full shadow-lg"
                                style="
                                    background:
                                    conic-gradient(
                                        #6366f1 0% 40%,
                                        #10b981 40% 68%,
                                        #f59e0b 68% 88%,
                                        #ec4899 88% 100%
                                    );
                                "
                            ></div>

                            <div class="absolute inset-8 bg-white rounded-full flex items-center justify-center shadow-inner">

                                <div class="text-center">

                                    <h3 class="text-3xl sm:text-4xl font-black text-primary-600">

                                        {{ $totalBorrowings }}

                                    </h3>

                                    <p class="text-slate-600 text-sm font-medium mt-1">

                                        Total Pinjam

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- LEGEND -->
                    <div class="space-y-3">

                        @foreach($topBooks->take(4) as $index => $book)

                            @php

                                $colors = [
                                    'bg-primary-500',
                                    'bg-emerald-500',
                                    'bg-amber-500',
                                    'bg-rose-500'
                                ];

                            @endphp

                            <div class="flex items-center justify-between p-3 rounded-lg hover:bg-slate-50 transition-colors duration-200">

                                <div class="flex items-center gap-3 min-w-0">

                                    <div class="w-3 h-3 rounded-full flex-shrink-0 {{ $colors[$index] }}"></div>

                                    <span class="text-slate-700 font-medium line-clamp-1 text-sm">

                                        {{ $book->judul }}

                                    </span>

                                </div>

                                <span class="font-bold text-slate-900 flex-shrink-0 ml-2 text-sm">

                                    {{ $book->borrowings_count }}x

                                </span>

                            </div>

                        @endforeach

                    </div>

                </x-card>

            </div>

            <!-- CONTENT -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">

                <!-- LEFT -->
                <div class="xl:col-span-2 space-y-6 lg:space-y-8">

                    <!-- BUKU TERBARU -->
                    <x-card class="p-6 lg:p-8 shadow-md border border-slate-100 hover:shadow-lg transition-shadow duration-300">

                        <div class="flex items-center justify-between mb-8">

                            <div>

                                <h2 class="text-2xl font-bold text-slate-900">

                                    📚 Buku Terbaru

                                </h2>

                                <p class="text-slate-600 text-sm mt-1 font-medium">

                                    Koleksi terbaru perpustakaan

                                </p>

                            </div>

                            <a
                                href="{{ route('katalog') }}"
                                class="text-primary-600 font-semibold hover:text-primary-700 transition-colors duration-200"
                            >
                                Lihat Semua
                            </a>

                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-5">

                            @foreach($latestBooks as $book)

                                <div class="group bg-slate-50 border border-slate-200 rounded-xl lg:rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 hover:scale-105 hover:border-primary-200">

                                    <div class="relative overflow-hidden bg-slate-200 h-48 sm:h-52">
                                        @if($book->cover)

                                            <img
                                                src="{{ asset('storage/' . $book->cover) }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                            >

                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-slate-300 to-slate-400 flex items-center justify-center text-4xl">📖</div>
                                        @endif
                                    </div>

                                    <div class="p-3 lg:p-4">

                                        <h3 class="font-semibold text-slate-900 line-clamp-2 mb-1 text-sm">

                                            {{ $book->judul }}

                                        </h3>

                                        <p class="text-xs text-slate-600 mb-4 line-clamp-1">

                                            {{ $book->penulis }}

                                        </p>

                                        <div class="flex items-center justify-between gap-2">

                                            <span class="text-xs bg-primary-100 text-primary-700 px-2 py-1 rounded-full font-semibold">

                                                Baru

                                            </span>

                                            <a
                                                href="{{ route('books.show', $book->id) }}"
                                                class="text-xs font-semibold text-primary-600 hover:text-primary-700 transition-colors duration-200"
                                            >

                                                Detail →

                                            </a>

                                        </div>
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>
                        <!-- SECTION MEMBER / USER -->
                        @if(auth()->user()->role == 'member')

                            <!-- LANJUTKAN MEMBACA -->
                            <div class="bg-gradient-to-br from-primary-600 via-primary-500 to-primary-700 rounded-2xl lg:rounded-3xl p-8 lg:p-10 shadow-2xl text-white overflow-hidden relative">

                                <div class="absolute -top-32 -right-32 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
                                <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-cyan-400/10 rounded-full blur-3xl"></div>

                                <div class="relative z-10">

                                    <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 px-4 py-2 rounded-full text-xs font-semibold mb-6 backdrop-blur">
                                        <span class="w-2 h-2 bg-cyan-300 rounded-full animate-pulse"></span>
                                        MEMBER DIGITAL
                                    </div>

                                    <h2 class="text-3xl lg:text-4xl font-black mb-4">
                                        📖 Lanjutkan Membaca Ebook
                                    </h2>

                                    <p class="text-cyan-50 text-base lg:text-lg max-w-3xl leading-relaxed mb-8 font-medium">

                                        Baca ebook favoritmu kapan saja, lanjutkan dari halaman terakhir, dan nikmati akses koleksi digital tanpa batas.

                                    </p>

                                    <div class="flex flex-col sm:flex-row gap-3">

                                        <a
                                            href="{{ route('my-books') }}"
                                            class="bg-white text-primary-700 font-semibold px-6 lg:px-8 py-3 lg:py-4 rounded-lg lg:rounded-xl hover:bg-slate-100 transition-colors duration-200 text-center"
                                        >
                                            Buka Buku Saya
                                        </a>

                                        <a
                                            href="{{ route('katalog') }}"
                                            class="bg-white/20 hover:bg-white/30 border border-white/30 px-6 lg:px-8 py-3 lg:py-4 rounded-lg lg:rounded-xl font-semibold transition-all duration-200 text-center backdrop-blur"
                                        >
                                            Cari Ebook
                                        </a>

                                    </div>

                                </div>

                            </div>

                        @else

                            <!-- ===================================== -->
                            <!-- AJUKAN MENJADI MEMBER -->
                            <!-- ===================================== -->

                            @if(auth()->user()->role === 'user')

                            <div class="relative overflow-hidden rounded-2xl lg:rounded-3xl bg-gradient-to-br from-primary-700 via-primary-700 to-primary-900 p-8 lg:p-10 shadow-2xl">

                                <!-- ORNAMENT -->
                                <div class="absolute -top-40 -right-40 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>

                                <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-primary-400/10 rounded-full blur-3xl"></div>

                                <!-- CONTENT -->
                                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

                                    <!-- LEFT -->
                                    <div class="flex-1">

                                        <!-- BADGE -->
                                        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 px-4 py-2 rounded-full mb-6 backdrop-blur">

                                            <span class="w-2 h-2 rounded-full bg-amber-300 animate-pulse"></span>

                                            <span class="text-xs font-bold tracking-widest text-primary-100 uppercase">
                                                Upgrade Member
                                            </span>

                                        </div>

                                        <!-- TITLE -->
                                        <h2 class="text-3xl lg:text-4xl xl:text-5xl font-black leading-tight text-white mb-4">

                                            Buka Akses
                                            <span class="text-primary-200">
                                                Buku Digital
                                            </span>

                                        </h2>

                                        <!-- DESC -->
                                        <p class="text-base lg:text-lg leading-relaxed text-primary-100 max-w-2xl mb-8 font-medium">

                                            Jadilah member untuk membaca ebook digital, mendapatkan limit peminjaman lebih banyak, dan akses koleksi premium perpustakaan.

                                        </p>

                                        <!-- BENEFIT -->
                                        <div class="flex flex-wrap gap-3">

                                            <div class="bg-white/10 border border-white/20 px-3 lg:px-4 py-2 rounded-lg text-xs lg:text-sm font-semibold text-white backdrop-blur">
                                                📚 Ebook Digital
                                            </div>

                                            <div class="bg-white/10 border border-white/20 px-3 lg:px-4 py-2 rounded-lg text-xs lg:text-sm font-semibold text-white backdrop-blur">
                                                🔥 Limit Pinjam Lebih Banyak
                                            </div>

                                            <div class="bg-white/10 border border-white/20 px-3 lg:px-4 py-2 rounded-lg text-xs lg:text-sm font-semibold text-white backdrop-blur">
                                                ⚡ Akses Member
                                            </div>

                                        </div>

                                    </div>

                                    <!-- RIGHT -->
                                    <div class="flex flex-col gap-4">

                                        <!-- BUTTON -->
                                        <form
                                            action="{{ route('member.request') }}"
                                            method="POST"
                                            class="w-full"
                                        >

                                            @csrf

                                            <button
                                                class="w-full bg-white hover:bg-primary-50 text-primary-700 font-semibold px-6 lg:px-8 py-3 lg:py-4 rounded-lg lg:rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 text-center"
                                            >
                                                Ajukan Menjadi Member
                                            </button>

                                        </form>

                                        <!-- INFO -->
                                        <div class="bg-white/10 border border-white/20 rounded-lg lg:rounded-xl p-4 backdrop-blur">

                                            <p class="text-xs lg:text-sm text-primary-100 leading-relaxed">

                                                Pengajuan akan ditinjau oleh admin. Setelah disetujui, akun Anda mendapat akses member lengkap.

                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            @endif

                        @endif
                </div>

                <!-- RIGHT -->
                <div class="space-y-6 lg:space-y-8">

                    <!-- TOP PEMINJAM -->
                    <x-card class="p-6 lg:p-8 shadow-md border border-slate-100 hover:shadow-lg transition-shadow duration-300">

                        <div class="mb-8">

                            <h2 class="text-2xl font-bold text-slate-900">

                                🏆 Top Peminjam

                            </h2>

                            <p class="text-slate-600 text-sm mt-2 font-medium">

                                Mahasiswa paling aktif bulan ini

                            </p>

                        </div>

                        <!-- DIAGRAM BATANG -->
                        <div class="flex items-end justify-between gap-2 sm:gap-3 h-64 sm:h-72">

                            @foreach($topUsers as $index => $user)

                                @php

                                    $heights = [
                                        'h-60',
                                        'h-52',
                                        'h-44',
                                        'h-36',
                                        'h-28'
                                    ];

                                    $colors = [
                                        'from-primary-500 to-cyan-400',
                                        'from-emerald-500 to-teal-400',
                                        'from-amber-500 to-yellow-400',
                                        'from-rose-500 to-pink-400',
                                        'from-purple-500 to-violet-400',
                                    ];

                                @endphp

                                <div class="flex flex-col items-center flex-1 group">

                                    <div
                                        class="w-full rounded-t-xl sm:rounded-t-2xl bg-gradient-to-t {{ $colors[$index] }} {{ $heights[$index] }} flex items-start justify-center pt-2 shadow-md hover:shadow-lg transition-all duration-300 group-hover:scale-105"
                                    >

                                        <span class="text-white text-xs sm:text-sm font-bold">

                                            {{ $user->borrowings_count }}

                                        </span>

                                    </div>

                                    <p class="text-xs text-center font-semibold text-slate-700 mt-2 line-clamp-2 w-full">

                                        {{ $user->name }}

                                    </p>

                                </div>

                            @endforeach

                        </div>

                    </div>

                    <!-- AKTIVITAS -->
                    <x-card class="p-6 lg:p-8 shadow-md border border-slate-100 hover:shadow-lg transition-shadow duration-300">

                        <h2 class="text-2xl font-bold text-slate-900 mb-7">

                            📊 Aktivitas Saya

                        </h2>

                        <div class="space-y-4">

                            <!-- SEDANG DIPINJAM -->
                            <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl border border-primary-200 p-5 hover:shadow-md transition-shadow duration-300">

                                <p class="text-primary-700 text-sm font-semibold mb-2">

                                    Sedang Dipinjam

                                </p>

                                <h3 class="text-4xl font-black text-primary-900">

                                    {{ $borrowedCount }}
                                    <span class="text-lg font-semibold ml-1">Buku</span>

                                </h3>

                            </div>

                            <!-- JATUH TEMPO -->
                            <div class="bg-gradient-to-br from-rose-50 to-red-100 rounded-xl border border-red-200 p-5 hover:shadow-md transition-shadow duration-300">

                                <p class="text-red-700 text-sm font-semibold mb-2">
                                    Jatuh Tempo Terdekat
                                </p>

                                <h3 class="text-4xl font-black text-red-900">

                                    @if($nearestDue)

                                        @php

                                        $hariLagi = floor(
                                            \Carbon\Carbon::now()->diffInDays(
                                                $nearestDue->tanggal_kembali,
                                                false
                                            )
                                        );

                                        @endphp

                                        @if($hariLagi > 0)

                                             {{ $hariLagi }}
                                             <span class="text-lg font-semibold">Hari</span>

                                        @elseif($hariLagi == 0)

                                            Hari Ini

                                        @else

                                            <span class="text-lg font-semibold">Terlambat</span>

                                        @endif

                                    @else

                                        Aman

                                    @endif

                                </h3>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
