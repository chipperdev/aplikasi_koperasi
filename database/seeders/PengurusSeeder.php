<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class PengurusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'Pengurus 1',
            'email' => 'pengurus2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'pengurus',
            'status' => 'approved'
        ]);
    }
}
