<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

        // ROLE DARI SWITCH LOGIN
        $selectedRole = $request->role;

        // LOGIN ADMIN
        if ($selectedRole == 'admin' && $user->role != 'admin') {

            Auth::logout();

            return back()->withErrors([
                'email' => 'Akun ini bukan admin.',
            ]);

        }

        // LOGIN MAHASISWA / MEMBER
        if ($selectedRole == 'member' && $user->role == 'admin') {

            Auth::logout();

            return back()->withErrors([
                'email' => 'Silakan login melalui mode admin.',
            ]);

        }

        // REDIRECT ADMIN
        if ($user->role == 'admin') {

            return redirect()->route('dashboard');

        }

        // REDIRECT USER / MEMBER
        return redirect()->route('beranda');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}