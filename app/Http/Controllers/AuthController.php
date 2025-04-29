<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'no_telepon' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('no_telepon', $request->no_telepon)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Nomor telepon atau password salah'
            ], 401);
        }

        if ($user->status != 'aktif') {
            return response()->json([
                'message' => 'Akun Anda belum diverifikasi oleh pengurus.'
            ], 403);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'role' => $user->role,
                'status' => $user->status,
            ]
        ]);
    }
}
