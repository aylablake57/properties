<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'user_type' => 'superadmin',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole('SuperAdmin');

        // $user = User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'user_type' => 'admin',
        //     'password' => Hash::make('12345678'),
        // ]);
        // $user->assignRole('Admin');

        // $user = User::create([
        //     'name' => 'User',
        //     'email' => 'user@gmail.com',
        //     'user_type' => 'user',
        //     'password' => Hash::make('12345678'),
        // ]);
        // $user->assignRole('User');

        // $user = User::create([
        //     'name' => 'Agent',
        //     'email' => 'agent@gmail.com',
        //     'user_type' => 'agent',
        //     'password' => Hash::make('12345678'),
        // ]);
        // $user->assignRole('Agent');

        // $user = User::create([
        //     'name' => 'Agency',
        //     'email' => 'agency@gmail.com',
        //     'user_type' => 'agency',
        //     'password' => Hash::make('12345678'),
        // ]);
        // $user->assignRole('Agency');    

        // $user = User::create([
        //     'name' => 'Seller',
        //     'email' => 'seller@gmail.com',
        //     'user_type' => 'seller',
        //     'password' => Hash::make('12345678'),
        // ]);
        // $user->assignRole('Seller');










        
        
        
        
    }
}
