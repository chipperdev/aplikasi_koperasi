<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
    
            return response()->json([
                'message' => 'Login berhasil',
                'token' => $token,
                'role' => $user->role
            ], 200);
        }
    
        return response()->json(['message' => 'Login gagal'], 401);
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
