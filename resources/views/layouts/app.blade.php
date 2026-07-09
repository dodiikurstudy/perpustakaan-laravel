<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'Laravel') }}
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
        rel="stylesheet"
    />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-100">

        @auth
            @include('layouts.navigation')
        @endauth

        @guest
            @include('layouts.guest-navigation')
        @endguest

        <!-- SUCCESS POPUP -->
        @if(session('success'))

            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 5000)"
                class="fixed inset-0 z-50 flex items-center justify-center"
            >

                <div
                    class="bg-green-500 text-white px-8 py-5 rounded-3xl shadow-2xl max-w-md w-full mx-4"
                >

                    <div class="flex items-center justify-between gap-5">

                        <p class="text-lg font-semibold">
                            {{ session('success') }}
                        </p>

                        <button
                            @click="show = false"
                            class="text-white text-2xl"
                        >
                            ×
                        </button>

                    </div>

                </div>

            </div>

        @endif

<!-- PREMIUM MODAL -->
@if(session('error') == 'PREMIUM_MODAL')

    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 5000)"
        class="fixed inset-0 z-50 flex items-center justify-center"
    >

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

        <!-- Modal -->
        <x-card class="relative w-full max-w-md mx-4 overflow-hidden rounded-[24px] shadow-2xl border-0 p-0">

            <!-- Close -->
            <button
                @click="show = false"
                class="absolute top-3 right-4 text-gray-400 hover:text-gray-600 text-3xl"
            >
                ×
            </button>

            <div class="px-7 py-8 text-center">

                <!-- Icon -->
                <div class="flex justify-center mb-4">

                    <div
                        class="w-16 h-16 rounded-2xl
                               bg-purple-100
                               flex items-center justify-center"
                    >
                        <span class="text-3xl">
                            📚
                        </span>
                    </div>

                </div>

                <!-- Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-4">

                    Batas Peminjaman Tercapai

                </h1>

                <!-- Description -->
                <p class="text-gray-600 text-sm leading-relaxed mb-6">

                    Akun reguler Anda telah mencapai batas peminjaman standar.
                    Tingkatkan ke

                    <span class="font-semibold text-purple-700">
                        Member Premium
                    </span>

                    untuk menikmati fitur eksklusif.

                </p>

                <!-- Benefits -->
                <div class="space-y-3 text-left mb-7">

                    <div class="flex items-start gap-3">

                        <span class="text-purple-600">
                            ✨
                        </span>

                        <span class="text-gray-700 text-sm">
                            Pinjam hingga 5 buku sekaligus
                        </span>

                    </div>

                    <div class="flex items-start gap-3">

                        <span class="text-purple-600">
                            ✨
                        </span>

                        <span class="text-gray-700 text-sm">
                            Akses lebih banyak buku digital
                        </span>

                    </div>

                    <div class="flex items-start gap-3">

                        <span class="text-purple-600">
                            ✨
                        </span>

                        <span class="text-gray-700 text-sm">
                            Pengalaman membaca tanpa batas
                        </span>

                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex justify-center gap-3">

                    <button
                        class="bg-purple-700 hover:bg-purple-800
                               text-white font-semibold text-sm
                               px-5 py-2.5 rounded-xl transition"
                    >
                        Upgrade
                    </button>

                    <button
                        @click="show = false"
                        class="bg-gray-200 hover:bg-gray-300
                               text-gray-700 font-semibold text-sm
                               px-5 py-2.5 rounded-xl transition"
                    >
                        Nanti
                    </button>

                </div>

            </div>

        </x-card>

    </div>

@endif
        <!-- ERROR BIASA -->
        @if(session('error') && session('error') != 'PREMIUM_MODAL')

            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 5000)"
                class="fixed inset-0 z-50 flex items-center justify-center"
            >

                <div
                    class="bg-red-500 text-white px-8 py-5 rounded-3xl shadow-2xl max-w-md w-full mx-4"
                >

                    <div class="flex items-center justify-between gap-5">

                        <p class="text-lg font-semibold">
                            {{ session('error') }}
                        </p>

                        <button
                            @click="show = false"
                            class="text-white text-2xl"
                        >
                            ×
                        </button>

                    </div>

                </div>

            </div>

        @endif

        <!-- HEADER -->
        @isset($header)

            <header class="bg-white shadow">

                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

                    {{ $header }}

                </div>

            </header>

        @endisset

        <!-- CONTENT -->
        <main>

            {{ $slot }}

        </main>

    </div>

</body>

</html>