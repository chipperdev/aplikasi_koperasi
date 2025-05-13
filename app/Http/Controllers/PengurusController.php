<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PengurusController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'role:pengurus']);
    }

    public function index()
    {
        return response()->json([
            'message' => 'Selamat datang di dashboard pengurus'
        ]);
    }

    public function listPendingAnggota()
    {
        $anggota = User::where('role', 'anggota')
                        ->where('status', 'pending')
                        ->get();

        return response()->json([
            'status' => true,
            'data' => $anggota
        ]);
    }

    public function approveAnggota($id)
    {
        return $this->ubahStatusAnggota($id, 'aktif', 'Anggota berhasil disetujui.');
    }

    public function rejectAnggota($id)
    {
        return $this->ubahStatusAnggota($id, 'ditolak', 'Anggota berhasil ditolak.');
    }

    private function ubahStatusAnggota($id, $status, $successMessage)
    {
        try {
            $anggota = User::where('id', $id)
                           ->where('role', 'anggota')
                           ->firstOrFail();

            $anggota->status = $status;
            $anggota->save();

            return response()->json([
                'status' => true,
                'message' => $successMessage,
                'data' => $anggota
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Anggota tidak ditemukan.'
            ], 404);
        }
    }

    public function jumlahAnggota()
    {
        $jumlah = User::where('role', 'anggota')->count();

        return response()->json([
            'status' => true,
            'total_anggota' => $jumlah
        ]);
    }

    public function detailStatusPendaftaran($id)
    {
        try {
            $anggota = User::where('id', $id)
                           ->where('role', 'anggota')
                           ->firstOrFail();

            $message = match ($anggota->status) {
                'aktif' => 'Pendaftaran Berhasil Diterima',
                'ditolak' => 'Pendaftaran Ditolak',
                'pending' => 'Menunggu Persetujuan',
                default => 'Status tidak diketahui',
            };

            return response()->json([
                'status' => true,
                'data' => [
                    'id' => $anggota->id,
                    'nama' => $anggota->nama,
                    'status' => $anggota->status,
                    'message' => $message,
                ]
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Anggota tidak ditemukan.'
            ], 404);
        }
    }

    public function hapusAnggota($id)
    {
        try {
            $anggota = User::where('id', $id)
                           ->where('role', 'anggota')
                           ->firstOrFail();

            $anggota->delete();

            return response()->json([
                'status' => true,
                'message' => 'Anggota berhasil dihapus.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Anggota tidak ditemukan.'
            ], 404);
        }
    }
}
