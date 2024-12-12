<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $students = [
            [
                'name' => 'John Doe',
                'school_id' => 'STU001',
                'email' => 'john.doe@student.university.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Jane Smith',
                'school_id' => 'STU002',
                'email' => 'jane.smith@student.university.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Alice Johnson',
                'school_id' => 'STU003',
                'email' => 'alice.johnson@student.university.com',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($students as $student) {
            $user = User::create($student);
            $user->assignRole('student');
        }
    }
}
