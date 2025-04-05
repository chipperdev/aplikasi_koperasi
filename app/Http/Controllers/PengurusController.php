<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PengurusController extends Controller
{

    public function index()
    {
        return response()->json([
            'message' => 'Selamat datang di dashboard pengawas'
        ]);
    }
    
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'role:pengurus']);
    }

    public function listPendingAnggota()
    {
        $anggota = User::where('role', 'anggota')->where('status', 'pending')->get();
        return response()->json($anggota);
    }

    public function approveAnggota($id)
    {
        $anggota = User::find($id);

        if (!$anggota || $anggota->role !== 'anggota') {
            return response()->json(['message' => 'Anggota tidak ditemukan.'], 404);
        }

        $anggota->status = 'approved';
        $anggota->save();

        return response()->json(['message' => 'Anggota berhasil disetujui.']);
    }

    public function rejectAnggota($id)
    {
        $anggota = User::find($id);

        if (!$anggota || $anggota->role !== 'anggota') {
            return response()->json(['message' => 'Anggota tidak ditemukan.'], 404);
        }

        $anggota->status = 'rejected';
        $anggota->save();

        return response()->json(['message' => 'Anggota berhasil ditolak.']);
    }

}
