# Boilerplate — Perpustakaan (Laravel Blade) 

Dokumen ini adalah **boilerplate ringkas** hasil scan struktur file yang ada di project. 
Tujuan: memberi “skeleton” pola Blade/Layour yang dipakai, tanpa mengubah logika file asli.

---

## 1) Konfigurasi umum View

- Aset dipasang via Vite di layout:
  - `@vite(['resources/css/app.css', 'resources/js/app.js'])`
- CSRF token pada form selalu pakai:
  - `@csrf`
- Komponen UI dipakai melalui Blade components seperti:
  - `<x-card>`
  - `<x-button>` / `<x-danger-button>`
  - `<x-dropdown>` / `<x-dropdown-link>` (di navigation)
  - `<x-input-error>`
- Layout umum:
  - untuk user authenticated: `<x-app-layout>`
  - untuk halaman publik/guest: `<x-guest-layout>`
  - untuk admin: `@extends('layouts.admin')` lalu `@section('content')`

---

## 2) Layout yang dipakai

### 2.1 `resources/views/layouts/app.blade.php` (User Shell)
- Struktur HTML:
  - `<body>` berisi: 
    - `@include('layouts.navigation')`
    - Popup berdasarkan session:
      - `session('success')`
      - `session('error')` dengan special case `PREMIUM_MODAL`
    - Optional header:
      - `@isset($header) ... {{ $header }} ... @endisset`
    - Konten:
      - `<main>{{ $slot }}</main>`

### 2.2 `resources/views/layouts/navigation.blade.php`
- Navbar sticky dengan menu kondisional:
  - Logo mengarah ke:
    - admin: `route('dashboard')`
    - selain admin: `route('beranda')`
  - Menu tengah tampil jika role bukan admin:
    - Beranda (`route('beranda')`)
    - Katalog (`route('katalog')`)
    - Buku Saya (`route('my-books')`)
- Dropdown profil menggunakan komponen:
  - Avatar dari `Auth::user()->avatar` bila ada
  - Menu dropdown berisi:
    - Profile (`route('profile.edit')`)
    - Beranda (`route('beranda')`)
    - Logout (form POST `route('logout')`)

### 2.3 `resources/views/layouts/admin.blade.php`
- Struktur umum:
  - Sidebar kiri (menu admin)
  - Yield section:
    - `@yield('content')`
- Route admin yang muncul:
  - `dashboard`
  - `books.index`
  - `users.index`
  - `member-requests.index`
  - `borrowings.admin`
  - `return-books.index`

### 2.4 `resources/views/layouts/guest.blade.php`
- Struktur login:
  - Logo + headline
  - Card form login `action="{{ route('login') }}"`
  - Hidden input `role` dipilih via tombol (member/admin)
  - Input login (`name="login"`)
  - Input password (`name="password"`)
  - `remember` checkbox
  - Link forgot-password memakai `Route::has('password.request')`.
  - Ada animasi marquee dekoratif.

---

## 3) Komponen yang dipakai

### `resources/views/components/card.blade.php`
- Wrapper card sederhana:
  - default class: `rounded-lg border border-slate-200 bg-white p-4 text-sm shadow-sm`
  - `{{ $slot }}` dipasang di dalamnya

---

## 4) Pola Blade pada halaman (Routes yang terlihat)

> Catatan: file-file blade yang lain memakai `@extends`, `@section('content')`, atau `<x-app-layout>`.
> Boilerplate ini merangkum pola yang terlihat dari layout & contoh halaman.

### 4.1 Halaman User menggunakan `<x-app-layout>`
Contoh pola umum:
- Mulai:
  - `<x-app-layout>`
- Konten utama dibuat dengan div + grid
- Navigasi / popup otomatis dari layout app

Halaman user yang ada di project (berdasarkan file yang terlihat):
- `resources/views/user/beranda.blade.php`
- `resources/views/user/katalog.blade.php`
- `resources/views/user/detail-book.blade.php`
- `resources/views/user/my-books.blade.php`
- `resources/views/user/history.blade.php`
- `resources/views/user/fines.blade.php`
- `resources/views/user/beranda_new.blade.php` (tidak dijadikan target utama bila route sudah diarahkan ke `beranda`)

### 4.2 Halaman Admin menggunakan `@extends('layouts.admin')`
Contoh pola:
- `@extends('layouts.admin')`
- `@section('content')`
- Isi berupa grid/tabel/kartu.

Halaman admin yang ada di project (berdasarkan file yang terlihat):
- `resources/views/admin/dashboard.blade.php`
- `resources/views/admin/users.blade.php`
- `resources/views/admin/member-requests.blade.php`
- `resources/views/admin/return-books.blade.php`
- `resources/views/books/index.blade.php`
- `resources/views/books/create.blade.php`
- `resources/views/books/edit.blade.php`

---

## 5) Checklist penggunaan komponen form & aksi

- Form POST/PUT/DELETE:
  - POST: `method="POST"`
  - PUT: `@method('PUT')`
  - DELETE: `@method('DELETE')`
- Validasi error:
  - gunakan `<x-input-error :messages="$errors->get('...')" />`
- Konfirmasi hapus:
  - `onsubmit="return confirm('Yakin hapus ...?')"`

---

## 6) Ringkasan Skeleton Template (siap dipakai sebagai referensi)

### 6.1 Skeleton User Page
```blade
<x-app-layout>
  <div class="..."> 
    @if(session('success')) ... @endif
    {{-- Konten halaman --}}
  </div>
</x-app-layout>
```

### 6.2 Skeleton Admin Page
```blade
@extends('layouts.admin')

@section('content')
  <div class="min-h-screen"> 
    {{-- Konten admin --}}
  </div>
@endsection
```

### 6.3 Skeleton Guest/Login Page
```blade
<x-guest-layout>
  <div class="...">
    <x-card class="...">
      <form method="POST" action="{{ route('login') }}">
        @csrf
        {{-- input role/login/password --}}
      </form>
    </x-card>
  </div>
</x-guest-layout>
```

---

## 7) Status file
- Dokumen ini **tidak mengubah** file Blade apa pun.
- Referensi hanya berasal dari struktur/layout yang ada.

---

Jika kamu ingin boilerplate ini dibuat menjadi **template yang benar-benar bisa dipakai otomatis** (mis. script generate halaman baru sesuai pola), minta format berikutnya: *generator md saja* atau *generator folder baru*.
