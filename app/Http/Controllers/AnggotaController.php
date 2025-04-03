<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'role:anggota']);
    }

    public function index()
    {
        return response()->json([
            'message' => 'Selamat datang di dashboard anggota',
        ]);
    }
}

