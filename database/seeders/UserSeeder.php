<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel users untuk memastikan data selalu bersih
        User::query()->delete();

        // 1. Buat Pengguna dengan Peran Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin', // <-- Peran diatur sebagai 'admin'
            'email_verified_at' => now(),
        ]);

        // 2. Buat Pengguna dengan Peran User Biasa
        User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'user', // <-- Peran diatur sebagai 'user'
            'email_verified_at' => now(),
        ]);
    }
}