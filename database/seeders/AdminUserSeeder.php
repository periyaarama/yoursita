<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Avoid duplicates if seeder is run multiple times
        $admin = User::firstOrCreate(
            ['email' => 'admin1@example.com'],
            [
                'username' => 'admin1',
                'password' => Hash::make('securepassword'),
                'firstName' => 'Admin',
                'lastName' => 'One',
                'phoneNumber' => '0123456789',
                'dateOfBirth' => '1990-01-01',
            ]
        );

        // Assign 'admin' role (must exist already from your RoleSeeder)
        $admin->assignRole('admin');
    }
}
