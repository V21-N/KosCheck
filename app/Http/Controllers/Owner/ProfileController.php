<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show profile edit form
     */
    public function edit()
    {
        $user = Auth::user();
        // ✅ Ubah dari 'owner.pengaturan-akun' menjadi 'pengaturanAkun'
        return view('pengaturanAkun', compact('user'));
    }

    /**
     * Update profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($request->only(['name', 'phone', 'address']));

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password (only for non-Google users)
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Jika user login dengan Google, tidak boleh ganti password
        if ($user->google_id) {
            return back()->with('error', 'Akun Google tidak bisa mengganti password melalui sini.');
        }

        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}