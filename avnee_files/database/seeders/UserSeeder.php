<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@avnee.in'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_blocked' => false,
            ]
        );

        // Dummy customer
        User::updateOrCreate(
            ['email' => 'customer@avnee.in'],
            [
                'name' => 'Test Customer',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'is_blocked' => false,
            ]
        );
    }
}
