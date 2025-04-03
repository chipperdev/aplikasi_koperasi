<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengawasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'role:pengawas']);
    }

    public function index()
    {
        return response()->json([
            'message' => 'Selamat datang di dashboard pengawas'
        ]);
    }
}
