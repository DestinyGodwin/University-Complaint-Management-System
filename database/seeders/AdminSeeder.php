<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = User::firstOrCreate([
            'school_id' => 'admin123',
            'email' => 'admin@university.com',
            'name' => 'University Admin',
        ], [
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole('admin');
    }
}
