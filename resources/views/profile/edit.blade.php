<x-app-layout>

    <div class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-primary-50 py-10 px-6">

        <div class="max-w-7xl mx-auto">

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                <!-- SIDEBAR -->
                <div>

                    <x-card class="bg-white/80 backdrop-blur-xl border border-white/50 rounded-[32px] shadow-xl p-8 sticky top-6">

                        <!-- AVATAR -->
                        <div class="flex flex-col items-center text-center">

                            <div class="w-32 h-32 rounded-full bg-gradient-to-r from-primary-500 to-primary-700 flex items-center justify-center text-white text-5xl font-black shadow-xl">

                                {{ strtoupper(substr($user->name, 0, 1)) }}

                            </div>

                            <h2 class="text-3xl font-black text-slate-800 mt-6">

                                {{ $user->name }}

                            </h2>

                            <p class="text-slate-500 mt-2">

                                {{ $user->email }}

                            </p>

                            <!-- ROLE -->
                            <div class="mt-6">

                                @if($user->role == 'admin')

                                    <span class="bg-red-100 text-red-600 px-5 py-2 rounded-full font-black">
                                        ADMIN
                                    </span>

                                @elseif($user->role == 'member')

                                    <span class="bg-violet-100 text-violet-600 px-5 py-2 rounded-full font-black">
                                        MEMBER
                                    </span>

                                @else

                                    <span class="bg-primary-100 text-primary-600 px-5 py-2 rounded-full font-black">
                                        USER
                                    </span>

                                @endif

                            </div>

                        </div>

                        <!-- INFO -->
                        <div class="mt-10 space-y-5">

                            <div class="bg-slate-100 rounded-2xl p-5">

                                <p class="text-sm text-slate-400 mb-1">
                                    Status Akun
                                </p>

                                <h3 class="text-xl font-black text-emerald-600">
                                    Aktif
                                </h3>

                            </div>

                            <div class="bg-slate-100 rounded-2xl p-5">

                                <p class="text-sm text-slate-400 mb-1">
                                    Tipe Pengguna
                                </p>

                                <h3 class="text-xl font-black text-slate-800">
                                    {{ ucfirst($user->role) }}
                                </h3>

                            </div>

                        </div>

                    </x-card>

                </div>

                <!-- CONTENT -->
                <div class="xl:col-span-2 space-y-8">

                    <!-- PROFILE -->
                    <x-card class="bg-white/80 backdrop-blur-xl border border-white/50 rounded-[32px] shadow-xl p-10">

                        <div class="mb-8">

                            <h2 class="text-3xl font-black text-slate-800">
                                Informasi Profile
                            </h2>

                            <p class="text-slate-500 mt-2">
                                Update informasi akun Anda.
                            </p>

                        </div>

                        <form
                            method="post"
                            action="{{ route('profile.update') }}"
                            class="space-y-6"
                        >

                            @csrf
                            @method('patch')

                            <!-- NAME -->
                            <div>

                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Nama Lengkap
                                </label>

                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name', $user->name) }}"
                                    class="w-full bg-slate-100 border-0 rounded-2xl px-5 py-4"
                                >

                                <x-input-error :messages="$errors->get('name')" class="mt-2" />

                            </div>

                            <!-- EMAIL -->
                            <div>

                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Email
                                </label>

                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="w-full bg-slate-100 border-0 rounded-2xl px-5 py-4"
                                >

                                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                            </div>

                            <!-- BUTTON -->
                            <div class="pt-4 flex items-center gap-4">
                                <x-button type="submit" class="bg-gradient-to-r from-primary-600 to-primary-700 hover:scale-[1.02] text-white font-black px-8 py-4 rounded-2xl shadow-xl">Simpan Perubahan</x-button>

                                @if (session('status') === 'profile-updated')

                                    <span class="text-emerald-600 font-bold">
                                        Berhasil disimpan
                                    </span>

                                @endif

                            </div>

                        </form>

                    </x-card>

                    <!-- PASSWORD -->
                    <x-card class="bg-white/80 backdrop-blur-xl border border-white/50 rounded-[32px] shadow-xl p-10">

                        <div class="mb-8">

                            <h2 class="text-3xl font-black text-slate-800">
                                Keamanan Akun
                            </h2>

                            <p class="text-slate-500 mt-2">
                                Ganti password untuk menjaga keamanan akun.
                            </p>

                        </div>

                        <form
                            method="post"
                            action="{{ route('password.update') }}"
                            class="space-y-6"
                        >

                            @csrf
                            @method('put')

                            <!-- CURRENT -->
                            <div>

                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Password Saat Ini
                                </label>

                                <input
                                    name="current_password"
                                    type="password"
                                    class="w-full bg-slate-100 border-0 rounded-2xl px-5 py-4"
                                >

                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />

                            </div>

                            <!-- NEW -->
                            <div>

                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Password Baru
                                </label>

                                <input
                                    name="password"
                                    type="password"
                                    class="w-full bg-slate-100 border-0 rounded-2xl px-5 py-4"
                                >

                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />

                            </div>

                            <!-- CONFIRM -->
                            <div>

                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Konfirmasi Password
                                </label>

                                <input
                                    name="password_confirmation"
                                    type="password"
                                    class="w-full bg-slate-100 border-0 rounded-2xl px-5 py-4"
                                >

                            </div>

                            <div class="pt-4 flex items-center gap-4">
                                <x-button type="submit" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:scale-[1.02] text-white font-black px-8 py-4 rounded-2xl shadow-xl">Update Password</x-button>

                                @if (session('status') === 'password-updated')

                                    <span class="text-emerald-600 font-bold">
                                        Password berhasil diupdate
                                    </span>

                                @endif

                            </div>

                        </form>

                    </x-card>

                    <!-- DELETE -->
                    <x-card class="bg-red-50 border border-red-100 rounded-[32px] shadow-xl p-10">

                        <div class="mb-8">

                            <h2 class="text-3xl font-black text-red-600">
                                Danger Zone
                            </h2>

                            <p class="text-red-400 mt-2">
                                Menghapus akun akan menghilangkan seluruh data secara permanen.
                            </p>

                        </div>

                        <form
                            method="post"
                            action="{{ route('profile.destroy') }}"
                            class="space-y-6"
                        >

                            @csrf
                            @method('delete')

                            <div>

                                <label class="block text-sm font-bold text-red-500 mb-2">
                                    Konfirmasi Password
                                </label>

                                <input
                                    name="password"
                                    type="password"
                                    class="w-full bg-white border border-red-100 rounded-2xl px-5 py-4"
                                    placeholder="Masukkan password"
                                >

                                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />

                            </div>

                            <x-danger-button type="submit" onclick="return confirm('Yakin ingin menghapus akun?')" class="bg-gradient-to-r from-red-500 to-red-600 hover:scale-[1.02]">Hapus Akun</x-danger-button>

                        </form>

                    </x-card>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>