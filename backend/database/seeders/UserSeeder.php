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
    public function run()
    {
        User::create([
            'name' => 'User Siswa',
            'email' => 'user@siswa.com',
            'password' => Hash::make('user'),
            'role' => 'user',
        ]);    
        User::create([
            'name' => 'Admin Siswa',
            'email' => 'admin@siswa.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);    
    }
}
