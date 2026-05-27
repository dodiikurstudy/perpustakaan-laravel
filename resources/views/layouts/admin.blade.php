<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <div class="w-60 bg-slate-900 text-white p-6 flex flex-col sticky top-0 h-screen">

            <div>

                <!-- LOGO -->
                <div class="mb-10">

                    <h1 class="text-3xl font-bold">
                        Admin
                    </h1>

                    <p class="text-gray-400 mt-2 text-sm">
                        Panel Perpustakaan
                    </p>

                </div>

                <!-- MENU -->
                <div class="space-y-3">

                    <a
                        href="{{ route('dashboard') }}"
                        class="block hover:bg-slate-800 px-4 py-3 rounded-2xl transition"
                    >

                        Dasbor

                    </a>

                    <a
                        href="{{ route('books.index') }}"
                        class="block hover:bg-slate-800 px-4 py-3 rounded-2xl transition"
                    >

                        Kelola Buku

                    </a>

                    <a
                        href="{{ route('users.index') }}"
                        class="block hover:bg-slate-800 px-4 py-3 rounded-2xl transition"
                    >

                        Mahasiswa

                    </a>

                    <a
                        href="{{ route('member-requests.index') }}"
                        class="block hover:bg-slate-800 px-4 py-3 rounded-2xl transition"
                    >

                        Pengajuan Member

                    </a>

                    <a
                        href="{{ route('borrowings.admin') }}"
                        class="block hover:bg-slate-800 px-4 py-3 rounded-2xl transition"
                    >

                        Transaksi

                    </a>

                    <a
                        href="{{ route('return-books.index') }}"
                        class="block hover:bg-slate-800 px-4 py-3 rounded-2xl transition"
                    >

                        Pengembalian

                    </a>

                </div>

            </div>

            <!-- LOGOUT -->
            <div class="mt-6">

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-2xl transition"
                    >

                        Logout

                    </button>

                </form>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="flex-1 p-2 overflow-hidden">
            @yield('content')

        </div>

    </div>

</body>

</html>