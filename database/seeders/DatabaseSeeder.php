<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'Pengawas 2',
            'email' => 'pengawas2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'pengawas',
            'status' => 'approved'
        ]);

        // Buat akun anggota
        User::create([
            'username' => 'Anggota 2',
            'email' => 'anggota2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'anggota',
            'status' => 'pending'
        ]);

        

        
    }
}
