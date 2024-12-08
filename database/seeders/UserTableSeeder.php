<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@example.com',
            'password' => Hash::make('secret'),
        ]);

        $superAdmin->assignRole('super-admin');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('secret'),
        ]);

        $admin->assignRole('admin');

        $agent = User::create([
            'name' => 'Agent',
            'email' => 'agent@example.com',
            'password' => Hash::make('secret'),
        ]);

        $agent->assignRole('agent');

        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('secret'),
        ]);

        $user->assignRole('user');
    }
}
