<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan halaman lupa password.
     */
    public function index()
    {
        return view('auth.forgot-password');
    }

    /**
     * Proses reset password.
     */
    public function update(Request $request)
    {
        $request->validate([

            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:6'],

        ]);

        // CARI USER BERDASARKAN EMAIL
        $user = User::where('email', $request->email)->first();

        // JIKA EMAIL TIDAK ADA
        if (!$user) {

            return back()->with(

                'error',
                'Email tidak ditemukan'

            );

        }

        // UPDATE PASSWORD
        $user->update([

            'password' => Hash::make($request->password),

        ]);

        return redirect()->route('login')->with(

            'status',
            'Password berhasil diubah'

        );
    }
}