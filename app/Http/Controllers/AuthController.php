<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'status' => 'pending',
        'role' => 'anggota',
    ]);

    return response()->json([
        'message' => 'Pendaftaran berhasil. Menunggu persetujuan pengawas.'
    ], 201);
}

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    if ($user->status !== 'approved') {
        return response()->json([
            'message' => 'Akun belum disetujui oleh pengawas.'
        ], 403);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
        'role' => $user->role,         // ← tambahkan ini
        'status' => $user->status,     // ← tambahkan ini
    ]);
    
}



    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $user->tokens()->delete(); // Menghapus semua token user
            return response()->json([
                'message' => 'Logout berhasil'
            ], 200);
        }

        return response()->json([
            'message' => 'Tidak ada pengguna yang login'
        ], 401);
    }
}
