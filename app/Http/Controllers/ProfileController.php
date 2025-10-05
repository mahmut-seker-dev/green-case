<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Profil sayfası
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Profil bilgilerini güncelle
     */
    public function update(Request $request)
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profil bilgileriniz başarıyla güncellendi.'
        ]);
    }

    /**
     * Şifre değiştir
     */
    public function updatePassword(Request $request)
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        $request->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'current_password.required' => 'Mevcut şifrenizi girmelisiniz.',
            'new_password.required' => 'Yeni şifrenizi girmelisiniz.',
            'new_password.confirmed' => 'Yeni şifre tekrarı eşleşmiyor.',
            'new_password.min' => 'Yeni şifre en az 6 karakter olmalıdır.',
        ]);

        // Eski şifre kontrolü
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Mevcut şifreniz yanlış!'
            ], 422);
        }

        // Yeni şifre eski şifre ile aynı olmamalı
        if (Hash::check($request->new_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Yeni şifre, mevcut şifrenizle aynı olamaz!'
            ], 422);
        }

        // Şifreyi güncelle
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Şifreniz başarıyla değiştirildi.'
        ]);
    }
}
