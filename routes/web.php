<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| WELCOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return redirect()->route('login');

});

/*
|--------------------------------------------------------------------------
| FORGOT PASSWORD
|--------------------------------------------------------------------------
*/

Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'update'])
    ->name('password.update.custom');

/*
|--------------------------------------------------------------------------
| USER / MEMBER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | BERANDA
    |--------------------------------------------------------------------------
    */

    Route::get('/beranda', [UserController::class, 'beranda'])
        ->name('beranda');




    /*
    |--------------------------------------------------------------------------
    | KATALOG
    |--------------------------------------------------------------------------
    */

    Route::get('/katalog', [UserController::class, 'katalog'])
        ->name('katalog');

    /*
    |--------------------------------------------------------------------------
    | DETAIL BUKU
    |--------------------------------------------------------------------------
    */

    Route::get('/books/{book}', [BookController::class, 'show'])
        ->name('books.show');

    /*
    |--------------------------------------------------------------------------
    | PINJAM BUKU
    |--------------------------------------------------------------------------
    */

    Route::post('/books/{book}/borrow', [BorrowingController::class, 'store'])
        ->name('borrowings.store');

    /*
    |--------------------------------------------------------------------------
    | BUKU SAYA
    |--------------------------------------------------------------------------
    */

    Route::get('/buku-saya', [BorrowingController::class, 'myBooks'])
        ->name('my-books');

    // FAVORITES
    Route::get('/favorit', [FavoriteController::class, 'index'])
        ->name('favorites');

    Route::post('/favorites/{book}', [FavoriteController::class, 'store'])
        ->name('favorites.store');

    Route::delete('/favorites/{book}', [FavoriteController::class, 'destroy'])
        ->name('favorites.destroy');

    // USER HISTORY & FINES
    Route::get('/riwayat', [UserController::class, 'history'])
        ->name('history');

    Route::get('/denda', [UserController::class, 'fines'])
        ->name('fines');

    /*
    |--------------------------------------------------------------------------
    | KEMBALIKAN BUKU
    |--------------------------------------------------------------------------
    */

    Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])
        ->name('borrowings.return');

    /*
    |--------------------------------------------------------------------------
    | PERPANJANG BUKU
    |--------------------------------------------------------------------------
    */

    Route::post('/borrowings/{borrowing}/extend', [BorrowingController::class, 'extend'])
        ->name('borrowings.extend');

    /*
    |--------------------------------------------------------------------------
    | KOMENTAR
    |--------------------------------------------------------------------------
    */

    Route::post('/books/{book}/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | UPGRADE MEMBER
    |--------------------------------------------------------------------------
    */    
    
    Route::post('/member-request', [UserController::class, 'requestMember'])
        ->name('member.request');

});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | KELOLA BUKU
    |--------------------------------------------------------------------------
    */

    // LIST BUKU
    Route::get('/admin/books', [BookController::class, 'index'])
        ->name('books.index');

    // FORM CREATE
    Route::get('/admin/books/create', [BookController::class, 'create'])
        ->name('books.create');

    // SIMPAN
    Route::post('/admin/books', [BookController::class, 'store'])
        ->name('books.store');

    // EDIT
    Route::get('/admin/books/{book}/edit', [BookController::class, 'edit'])
        ->name('books.edit');

    // UPDATE
    Route::put('/admin/books/{book}', [BookController::class, 'update'])
        ->name('books.update');

    // DELETE
    Route::delete('/admin/books/{book}', [BookController::class, 'destroy'])
        ->name('books.destroy');

    /*
    |--------------------------------------------------------------------------
    | MANAJEMEN USER
    |--------------------------------------------------------------------------
    */

    // LIST USER
    Route::get('/users', [AdminController::class, 'users'])
        ->name('users.index');

    // FORM CREATE USER
    Route::get('/users/create', [AdminController::class, 'createUser'])
        ->name('users.create');

    // STORE USER
    Route::post('/users/store', [AdminController::class, 'storeUser'])
        ->name('users.store');

    // UPDATE ROLE
    Route::put('/users/{user}/role', [AdminController::class, 'updateRole'])
        ->name('users.updateRole');

    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI
    |--------------------------------------------------------------------------
    */

    Route::get('/transaksi', [BorrowingController::class, 'adminIndex'])
        ->name('borrowings.admin');

    /*
    |--------------------------------------------------------------------------
    | PENGAJUAN MEMBER
    |--------------------------------------------------------------------------
    */

    Route::get('/member-requests', [AdminController::class, 'memberRequests'])
        ->name('member-requests.index');

    Route::post('/member-requests/{memberRequest}/approve', [AdminController::class, 'approveMember'])
        ->name('member-requests.approve');

    Route::post('/member-requests/{memberRequest}/reject', [AdminController::class, 'rejectMember'])
        ->name('member-requests.reject');

    /*
    |--------------------------------------------------------------------------
    | PENGEMBALIAN BUKU TERLAMBAT
    |--------------------------------------------------------------------------
    */

    Route::get('/return-books', [AdminController::class, 'pendingReturns'])
        ->name('return-books.index');

    Route::post('/return-books/{borrowing}/confirm', [AdminController::class, 'confirmReturn'])
        ->name('return-books.confirm');

});

require __DIR__.'/auth.php';