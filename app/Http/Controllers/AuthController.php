<?php

// ============================================
// app/Http/Controllers/AuthController.php
// ============================================

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;  
use App\Mail\VerificationEmail;

class AuthController extends Controller
{
    // Tampilkan form registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|min:6|confirmed',
            'full_name' => 'required|max:100',
            'role' => 'required|in:pelajar,mentor'
        ]);

        // Buat user baru
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'full_name' => $request->full_name,
            'role' => $request->role,
            'is_verified' => false,
            'is_active' => true
        ]);

        // Buat token verifikasi
        // TODO: Kirim email verifikasi
        // Mail::to($user->email)->send(new VerificationEmail($token));

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan cek email untuk verifikasi.');
    }

    // Tampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            return back()->withErrors(['email' => 'Email atau password salah']);
        }

        if (!$user->is_active) {
            return back()->withErrors(['email' => 'Akun Anda tidak aktif']);
        }

        Auth::login($user);

        // Redirect berdasarkan role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isMentor()) {
            return redirect()->route('mentor.dashboard');
        } else {
            return redirect()->route('dashboard.user');
        }
    }
    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
