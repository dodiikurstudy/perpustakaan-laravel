@extends('layouts.admin')

@section('content')

<div class="p-10">

    <x-card class="max-w-3xl mx-auto p-8 rounded-2xl shadow">

        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-800">
                Tambah User Baru
            </h1>

            <p class="text-gray-500 mt-2">
                Buat akun admin, member, atau user baru
            </p>

        </div>

        @if ($errors->any())

            <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl">

                <ul class="list-disc pl-5">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form
            action="{{ route('users.store') }}"
            method="POST"
            class="space-y-6"
        >

            @csrf

            <!-- NAMA -->
            <div>

                <label class="block mb-2 font-semibold text-gray-700">
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary-500"
                    required
                >

            </div>

            <!-- NPM -->
            <div>

                <label class="block mb-2 font-semibold text-gray-700">
                    NPM
                </label>

                <input
                    type="text"
                    name="npm"
                    value="{{ old('npm') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary-500"
                    required
                >

            </div>

            <!-- EMAIL -->
            <div>

                <label class="block mb-2 font-semibold text-gray-700">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary-500"
                    required
                >

            </div>

            <!-- PASSWORD -->
            <div>

                <label class="block mb-2 font-semibold text-gray-700">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary-500"
                    required
                >

            </div>

            <!-- ROLE -->
            <div>

                <label class="block mb-2 font-semibold text-gray-700">
                    Role
                </label>

                <select
                    name="role"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary-500"
                    required
                >

                    <option value="user">
                        User
                    </option>

                    <option value="member">
                        Member
                    </option>

                    <option value="admin">
                        Admin
                    </option>

                </select>

            </div>

            <!-- BUTTON -->
            <div class="flex items-center gap-4 pt-4">

                <button
                    type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl transition"
                >
                    Simpan User
                </button>

                <a
                    href="{{ route('users.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl transition"
                >
                    Kembali
                </a>

            </div>

        </form>

    </x-card>

</div>

@endsection