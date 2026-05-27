<x-app-layout>

<div class="min-h-screen bg-slate-100">

    <div class="max-w-[1600px] mx-auto px-5 py-6">

        <!-- ================= HERO ================= -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">

            <!-- HERO LEFT -->
            <div class="xl:col-span-2 bg-gradient-to-r from-amber-700 via-orange-600 to-orange-500 rounded-[30px] p-8 shadow-xl overflow-hidden relative">

                <div class="absolute inset-0 bg-black/10"></div>

                <div class="relative z-10">

                    <h1 class="text-4xl md:text-5xl font-black text-white mb-3">
                        Selamat datang kembali, {{ auth()->user()->name }}
                    </h1>

                    <p class="text-amber-100 text-lg mb-6">
                        Temukan buku favoritmu hari ini.
                    </p>

                    <!-- SEARCH -->
                    <form
                        action="{{ route('katalog') }}"
                        method="GET"
                        class="flex items-center bg-white rounded-2xl overflow-hidden shadow-sm max-w-3xl"
                    >

                        <input
                            type="text"
                            name="search"
                            placeholder="Cari judul, penulis, kategori..."
                            class="w-full px-4 py-3 border-0 focus:ring-0 text-slate-700"
                        >

                        <button
                            type="submit"
                            class="bg-gradient-to-r from-pink-500 to-orange-400 text-white px-6 py-2 font-bold"
                        >
                            Cari
                        </button>

                    </form>

                    <a
                        href="{{ route('katalog') }}"
                        class="inline-flex items-center gap-2 mt-5 text-white font-semibold hover:underline"
                    >
                        Jelajahi Katalog Lengkap →
                    </a>

                    <!-- QUICK MENU -->
                    <div class="mt-8 grid grid-cols-2 md:grid-cols-6 gap-4">

                        @foreach([
                            ['route'=>'my-books','label'=>'Buku Saya','sub'=>'Koleksi','color'=>'bg-blue-500','icon'=>'B'],
                            ['route'=>'katalog','label'=>'Katalog','sub'=>'Semua Buku','color'=>'bg-emerald-500','icon'=>'K'],
                            ['route'=>'favorites','label'=>'Favorit','sub'=>'Wishlist','color'=>'bg-pink-500','icon'=>'F'],
                            ['route'=>'history','label'=>'Riwayat','sub'=>'Aktivitas','color'=>'bg-orange-500','icon'=>'R'],
                            ['route'=>'fines','label'=>'Denda','sub'=>'Tagihan','color'=>'bg-violet-500','icon'=>'D'],
                            ['route'=>'profile.edit','label'=>'Profil','sub'=>'Pengaturan','color'=>'bg-sky-500','icon'=>'P'],
                        ] as $menu)

                        <a
                            href="{{ route($menu['route']) }}"
                            class="bg-white/15 backdrop-blur border border-white/10 rounded-2xl p-4 flex items-center gap-3 hover:bg-white/20 transition"
                        >

                            <div class="w-10 h-10 rounded-lg {{ $menu['color'] }} flex items-center justify-center text-sm font-bold text-white">
                                {{ $menu['icon'] }}
                            </div>

                            <div class="text-white">
                                <p class="font-bold text-sm">{{ $menu['label'] }}</p>
                                <p class="text-xs text-white/70">{{ $menu['sub'] }}</p>
                            </div>

                        </a>

                        @endforeach

                    </div>

                </div>

            </div>

            <!-- ================= BUKU TERPOPULER ================= -->
            <x-card class="p-6">

                <div class="mb-6">

                    <h2 class="text-2xl font-black text-slate-800">
                        Buku Terpopuler
                    </h2>

                    <p class="text-slate-500 text-sm mt-1">
                        Berdasarkan total peminjaman
                    </p>

                </div>

                <div class="flex gap-6 items-center">

                    <!-- CHART -->
                    <div class="relative w-64 h-64 shrink-0">

                        <div
                            class="w-full h-full rounded-full"
                            style="background: conic-gradient(
                                #3b82f6 0% 40%,
                                #10b981 40% 68%,
                                #f59e0b 68% 88%,
                                #ec4899 88% 100%
                            );"
                        ></div>

                        <div class="absolute inset-10 bg-white rounded-full flex items-center justify-center">

                            <div class="text-center">

                                <div class="text-4xl font-black text-slate-800">
                                    {{ $totalBorrowings }}
                                </div>

                                <p class="text-sm text-slate-500">
                                    Total Pinjam
                                </p>

                            </div>

                        </div>

                    </div>

                    <!-- LEGEND -->
                    <div class="flex-1 space-y-3">

                        @foreach($topBooks->take(4) as $index => $book)

                            @php
                                $colors = [
                                    'bg-blue-500',
                                    'bg-emerald-500',
                                    'bg-orange-500',
                                    'bg-pink-500'
                                ];
                            @endphp

                            <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3">

                                <div class="flex items-center gap-3 min-w-0">

                                    <div class="w-3 h-3 rounded-full {{ $colors[$index] }}"></div>

                                    <span class="text-slate-700 font-medium truncate">
                                        {{ $book->judul }}
                                    </span>

                                </div>

                                <span class="font-bold text-slate-800 whitespace-nowrap">
                                    {{ $book->borrowings_count }}x
                                </span>

                            </div>

                        @endforeach

                    </div>

                </div>

            </x-card>

        </div>

        <!-- ================= CONTENT ================= -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <!-- LEFT -->
            <div class="xl:col-span-2 space-y-6">

                <!-- BUKU TERBARU -->
                <x-card class="p-6">

                    <div class="flex items-center justify-between mb-6">

                        <div>

                            <h2 class="text-2xl font-black text-slate-800">
                                Buku Terbaru
                            </h2>

                            <p class="text-slate-500">
                                Koleksi terbaru perpustakaan
                            </p>

                        </div>

                        <a
                            href="{{ route('katalog') }}"
                            class="text-primary-600 font-bold hover:underline"
                        >
                            Lihat Semua
                        </a>

                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">

                        @foreach($latestBooks as $book)

                        <div class="bg-slate-50 rounded-2xl p-3 border border-slate-200 hover:shadow-lg transition">

                            <div class="relative w-full h-72 overflow-hidden rounded-xl mb-4">

                                <img
                                    src="{{ asset('storage/' . $book->cover) }}"
                                    class="absolute inset-0 w-full h-full object-cover object-center scale-105"
                                >

                            </div>

                            <h3 class="font-bold text-slate-800 line-clamp-2 mb-1">
                                {{ $book->judul }}
                            </h3>

                            <p class="text-sm text-slate-500 mb-3">
                                {{ $book->penulis }}
                            </p>

                            <a
                                href="{{ route('books.show', $book->id) }}"
                                class="text-sm font-semibold text-primary-600"
                            >
                                Detail
                            </a>

                        </div>

                        @endforeach

                    </div>

                </x-card>

                <!-- ================= MEMBER / USER SECTION ================= -->

                @if(auth()->user()->role == 'member')

                <!-- LANJUTKAN MEMBACA -->
                <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-700 rounded-3xl p-7 shadow-xl text-white overflow-hidden relative">

                    <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>

                    <div class="relative z-10">

                        <span class="bg-white/10 px-4 py-2 rounded-full text-sm font-bold inline-block mb-5">
                            MEMBER DIGITAL
                        </span>

                        <h2 class="text-4xl font-black mb-4">
                            Lanjutkan Membaca Ebook
                        </h2>

                        <p class="text-cyan-100 text-lg max-w-3xl leading-relaxed mb-8">

                            Kamu dapat membaca kembali ebook favoritmu,
                            melanjutkan halaman terakhir,
                            dan menikmati akses digital tanpa batas.

                        </p>

                        <div class="flex flex-wrap gap-4">

                            <a
                                href="{{ route('my-books') }}"
                                class="bg-white text-teal-700 font-black px-8 py-4 rounded-2xl hover:scale-105 transition"
                            >
                                Buka Buku Saya
                            </a>

                            <a
                                href="{{ route('katalog') }}"
                                class="bg-white/10 border border-white/10 px-8 py-4 rounded-2xl font-bold hover:bg-white/20 transition"
                            >
                                Cari Ebook
                            </a>

                        </div>

                    </div>

                </div>

                @else

                    <!-- AJUKAN MENJADI MEMBER -->
                    @if(auth()->user()->role === 'user')

                    <div class="relative overflow-hidden rounded-[32px] bg-gradient-to-br from-indigo-700 via-blue-700 to-slate-900 p-8 shadow-2xl">

                        <!-- ORNAMENT -->
                        <div class="absolute -top-24 -right-24 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>

                        <div class="absolute bottom-0 left-0 w-60 h-60 bg-blue-400/10 rounded-full blur-3xl"></div>

                        <!-- CONTENT -->
                        <div class="relative z-10 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-8">

                            <!-- LEFT -->
                            <div class="max-w-3xl">

                                <!-- BADGE -->
                                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 px-4 py-2 rounded-full mb-5">

                                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>

                                    <span class="text-sm font-bold tracking-wide text-blue-100 uppercase">
                                        Upgrade Member
                                    </span>

                                </div>

                                <!-- TITLE -->
                                <h2 class="text-4xl xl:text-5xl font-black leading-tight text-white">

                                    Buka Akses
                                    <span class="text-blue-200">
                                        Buku Digital
                                    </span>

                                </h2>

                                <!-- DESC -->
                                <p class="mt-5 text-lg leading-relaxed text-blue-100 max-w-2xl">

                                    Jadilah member perpustakaan untuk membaca ebook digital,
                                    mendapatkan limit peminjaman lebih banyak,
                                    dan menikmati akses koleksi premium perpustakaan.

                                </p>

                                <!-- BENEFIT -->
                                <div class="flex flex-wrap gap-3 mt-6">

                                    <div class="bg-white/10 border border-white/10 px-4 py-2 rounded-xl text-sm font-semibold text-white">
                                        📚 Ebook Digital
                                    </div>

                                    <div class="bg-white/10 border border-white/10 px-4 py-2 rounded-xl text-sm font-semibold text-white">
                                        🔥 Limit Pinjam Lebih Banyak
                                    </div>

                                    <div class="bg-white/10 border border-white/10 px-4 py-2 rounded-xl text-sm font-semibold text-white">
                                        ⚡ Akses Member
                                    </div>

                                </div>

                            </div>

                            <!-- RIGHT -->
                            <div class="flex flex-col gap-4 min-w-[260px]">

                                <form
                                    action="{{ route('member.request') }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        class="w-full bg-white text-indigo-700 hover:bg-slate-100 px-7 py-4 rounded-2xl font-black text-lg shadow-lg hover:scale-105 transition-all duration-200"
                                    >
                                        Ajukan Menjadi Member
                                    </button>

                                </form>

                                <div class="bg-white/10 border border-white/10 rounded-2xl p-4">

                                    <p class="text-sm text-blue-100 leading-relaxed">

                                        Pengajuan akan ditinjau oleh admin perpustakaan.
                                        Setelah disetujui, akun Anda akan mendapatkan akses member.

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    @endif

                @endif

            </div>

            <!-- RIGHT -->
            <div class="space-y-6">

                <!-- TOP PEMINJAM -->
                <x-card class="p-6">

                    <h2 class="text-2xl font-black mb-5">
                        Top Peminjam
                    </h2>

                    <div class="flex items-end justify-between gap-4 h-72">

                        @foreach($topUsers as $index => $user)

                            @php
                                $heights = ['h-64','h-56','h-48','h-40','h-32'];

                                $colors = [
                                    'from-primary-500 to-primary-400',
                                    'from-emerald-500 to-green-400',
                                    'from-orange-500 to-yellow-400',
                                    'from-pink-500 to-rose-400',
                                    'from-violet-500 to-purple-400',
                                ];
                            @endphp

                            <div class="flex flex-col items-center flex-1">

                                <div class="w-full rounded-t-2xl bg-gradient-to-t {{ $colors[$index] }} {{ $heights[$index] }} flex items-start justify-center pt-3">

                                    <span class="text-white text-sm font-bold">
                                        {{ $user->borrowings_count }}
                                    </span>

                                </div>

                                <p class="text-xs text-center font-semibold mt-3">
                                    {{ $user->name }}
                                </p>

                            </div>

                        @endforeach

                    </div>

                </x-card>

                <!-- AKTIVITAS -->
                <x-card class="p-6">

                    <h2 class="text-2xl font-black mb-5">
                        Aktivitas Saya
                    </h2>

                    <div class="space-y-4">

                        <div class="bg-slate-100 rounded-2xl p-4">

                            <p class="text-sm text-slate-500">
                                Sedang Dipinjam
                            </p>

                            <div class="text-3xl font-black">
                                {{ $borrowedCount }} Buku
                            </div>

                        </div>

                        <div class="bg-red-50 border border-red-100 rounded-2xl p-4">

                            <p class="text-sm text-red-500">
                                Jatuh Tempo Terdekat
                            </p>

                            <div class="text-xl font-black text-red-600">

                                @if($nearestDue)

                                    @php
                                        $hariLagi = floor(\Carbon\Carbon::now()->diffInDays($nearestDue->tanggal_kembali,false));
                                    @endphp

                                    @if($hariLagi > 0)

                                        {{ $hariLagi }} Hari

                                    @elseif($hariLagi == 0)

                                        Hari Ini

                                    @else

                                        Terlambat {{ abs($hariLagi) }} Hari

                                    @endif

                                @else

                                    Tidak Ada

                                @endif

                            </div>

                        </div>

                    </div>

                </x-card>

            </div>

        </div>

    </div>

</div>

</x-app-layout>