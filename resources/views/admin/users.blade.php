@extends('layouts.admin')

@section('content')

<div class="p-10">

<x-card class="p-8">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-8">

        <div>

            <h1 class="text-4xl font-black text-slate-800">
                Manajemen Mahasiswa
            </h1>

            <p class="text-slate-500 mt-2">
                Kelola akun dan role pengguna perpustakaan
            </p>

        </div>

        <!-- BUTTON TAMBAH USER -->
        <a
            href="{{ route('users.create') }}"
            class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-2xl font-bold shadow transition"
        >
            + Tambah User
        </a>

    </div>

    <!-- ALERT SUCCESS -->
    @if(session('success'))

        <div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-5 py-4 rounded-2xl">

            {{ session('success') }}

        </div>

    @endif

    <!-- TABLE -->
    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>

                <tr class="border-b bg-slate-50">

                    <th class="p-5 text-left font-bold text-slate-700">
                        Nama
                    </th>

                    <th class="p-5 text-left font-bold text-slate-700">
                        Email
                    </th>

                    <th class="p-5 text-left font-bold text-slate-700">
                        Role
                    </th>

                    <th class="p-5 text-left font-bold text-slate-700">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                    <tr class="border-b hover:bg-slate-50 transition">

                        <!-- NAMA -->
                        <td class="p-5">

                            <div class="font-bold text-slate-800">
                                {{ $user->name }}
                            </div>

                        </td>

                        <!-- EMAIL -->
                        <td class="p-5 text-slate-600">

                            {{ $user->email }}

                        </td>

                        <!-- ROLE -->
                        <td class="p-5">

                            <span
                                class="
                                    px-4 py-2 rounded-full text-sm font-bold

                                    @if($user->role == 'admin')
                                        bg-red-100 text-red-600
                                    @elseif($user->role == 'member')
                                        bg-purple-100 text-purple-700
                                    @else
                                        bg-primary-100 text-primary-700
                                    @endif
                                "
                            >

                                {{ ucfirst($user->role) }}

                            </span>

                        </td>

                        <!-- AKSI -->
                        <td class="p-5">

                            <form
                                action="{{ route('users.updateRole', $user->id) }}"
                                method="POST"
                                class="flex items-center gap-3"
                            >

                                @csrf
                                @method('PUT')

                                <select
                                    name="role"
                                    class="border border-slate-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                >

                                    <option
                                        value="user"
                                        {{ $user->role == 'user' ? 'selected' : '' }}
                                    >
                                        User
                                    </option>

                                    <option
                                        value="member"
                                        {{ $user->role == 'member' ? 'selected' : '' }}
                                    >
                                        Member
                                    </option>

                                    <option
                                        value="admin"
                                        {{ $user->role == 'admin' ? 'selected' : '' }}
                                    >
                                        Admin
                                    </option>

                                </select>

                                <x-button type="submit" class="px-5 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-semibold">Update</x-button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="p-10 text-center text-slate-500">

                            Belum ada data user

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</x-card>

</div>

@endsection
