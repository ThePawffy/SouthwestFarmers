<?php

namespace Database\Seeders;

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
        // 1. Super Admin
        User::create([
            'name'     => 'Super Admin',
            'email'    => 'superadmin@acnoo.com',
            'password' => Hash::make('superadmin'), // Password encrypt ho raha hai
            // 'role_id' => 1, // Note: Agar aapke database me 'role_id' column hai, toh uncomment karein
        ]);

        // 2. Admin
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@acnoo.com',
            'password' => Hash::make('admin'),
            // 'role_id' => 2,
        ]);

        // 3. Manager
        User::create([
            'name'     => 'Manager',
            'email'    => 'manager@acnoo.com',
            'password' => Hash::make('manager'),
            // 'role_id' => 3,
        ]);
        
        // 4. User (Normal)
        User::create([
            'name'     => 'User',
            'email'    => 'user@acnoo.com',
            'password' => Hash::make('user'), // Iska password aapne nahi diya tha, toh 'user' rakh diya
            // 'role_id' => 4,
        ]);
    }
}