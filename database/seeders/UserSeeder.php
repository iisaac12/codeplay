<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'username' => 'admin',
            'email' => 'admin@codeplay.com',
            'password_hash' => Hash::make('password'),
            'full_name' => 'Admin CodePlay',
            'role' => 'admin',
            'is_verified' => true,
            'is_active' => true,
        ]);

        // Mentor 1
        User::create([
            'username' => 'budi_mentor',
            'email' => 'budi@codeplay.com',
            'password_hash' => Hash::make('password'),
            'full_name' => 'Budi Santoso',
            'role' => 'mentor',
            'is_verified' => true,
            'is_active' => true,
        ]);

        // Mentor 2
        User::create([
            'username' => 'siti_mentor',
            'email' => 'siti@codeplay.com',
            'password_hash' => Hash::make('password'),
            'full_name' => 'Siti Nurhaliza',
            'role' => 'mentor',
            'is_verified' => true,
            'is_active' => true,
        ]);

        // Mentor 3
        User::create([
            'username' => 'agus_mentor',
            'email' => 'agus@codeplay.com',
            'password_hash' => Hash::make('password'),
            'full_name' => 'Agus Wijaya',
            'role' => 'mentor',
            'is_verified' => true,
            'is_active' => true,
        ]);

        // Pelajar 1
        User::create([
            'username' => 'andi_student',
            'email' => 'andi@student.com',
            'password_hash' => Hash::make('password'),
            'full_name' => 'Andi Pratama',
            'role' => 'pelajar',
            'is_verified' => true,
            'is_active' => true,
        ]);

        // Pelajar 2
        User::create([
            'username' => 'dewi_student',
            'email' => 'dewi@student.com',
            'password_hash' => Hash::make('password'),
            'full_name' => 'Dewi Lestari',
            'role' => 'pelajar',
            'is_verified' => true,
            'is_active' => true,
        ]);

        // Pelajar 3
        User::create([
            'username' => 'rudi_student',
            'email' => 'rudi@student.com',
            'password_hash' => Hash::make('password'),
            'full_name' => 'Rudi Hartono',
            'role' => 'pelajar',
            'is_verified' => true,
            'is_active' => true,
        ]);

        // Pelajar 4
        User::create([
            'username' => 'maya_student',
            'email' => 'maya@student.com',
            'password_hash' => Hash::make('password'),
            'full_name' => 'Maya Sari',
            'role' => 'pelajar',
            'is_verified' => true,
            'is_active' => true,
        ]);

        // Pelajar 5
        User::create([
            'username' => 'joko_student',
            'email' => 'joko@student.com',
            'password_hash' => Hash::make('password'),
            'full_name' => 'Joko Widodo',
            'role' => 'pelajar',
            'is_verified' => true,
            'is_active' => true,
        ]);
    }
}
