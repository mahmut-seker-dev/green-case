<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@greenholding.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manager User',
                'email' => 'manager@greenholding.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Staff User',
                'email' => 'staff@greenholding.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
