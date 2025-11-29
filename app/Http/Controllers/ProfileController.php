<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Menampilkan Halaman Profil (Show)
     * Berisi info user, tombol Edit, dan tombol Logout.
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Menampilkan Form Edit Profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Memproses Update Profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|min:6|confirmed', // password_confirmation wajib jika password diisi
        ]);

        // 1. Update Data Dasar
        $user->full_name = $request->full_name;
        $user->email = $request->email;

        // 2. Update Password (Jika diisi)
        if ($request->filled('password')) {
            $user->password_hash = Hash::make($request->password);
        }

        // 3. Update Avatar (Jika ada upload file)
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika bukan default/url eksternal
            if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
                Storage::disk('public')->delete($user->avatar_url);
            }

            // Simpan yang baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_url = $path; // Simpan path-nya saja (misal: avatars/foto.jpg)
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }
}