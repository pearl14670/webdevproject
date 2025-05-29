<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'password123',
                'is_blocked' => false,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => 'password123',
                'is_blocked' => false,
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'password' => 'password123',
                'is_blocked' => false,
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah@example.com',
                'password' => 'password123',
                'is_blocked' => false,
            ],
            [
                'name' => 'David Brown',
                'email' => 'david@example.com',
                'password' => 'password123',
                'is_blocked' => false,
            ],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'is_blocked' => $userData['is_blocked'],
                'email_verified_at' => now(),
            ]);
        }
    }
} 