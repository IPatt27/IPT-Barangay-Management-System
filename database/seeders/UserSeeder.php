<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('adminadmin'),
        ]);
        $admin->assignRole('admin');

        // Secretary
        $secretary = User::create([
            'name'     => 'Secretary',
            'email'    => 'secretary@gmail.com',
            'password' => Hash::make('secretary'),
        ]);
        $secretary->assignRole('secretary');

        // Committee
        $committee = User::create([
            'name'     => 'Committee',
            'email'    => 'committee@gmail.com',
            'password' => Hash::make('committee'),
        ]);
        $committee->assignRole('committee');
    }
}