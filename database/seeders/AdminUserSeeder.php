<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin SSGS',
            'email' => 'superadmin@ssgs.com',
            'password' => Hash::make('ssgsyogya123'),
            'role' => 'admin',
        ]);

        // HC
        User::create([
            'name' => 'Human Capital',
            'email' => 'hc@ssgs.com',
            'password' => Hash::make('ssgsyogya123'),
            'role' => 'hc',
        ]);

        // User
        User::create([
            'name' => 'User SSGS',
            'email' => 'user@ssgs.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }
}
