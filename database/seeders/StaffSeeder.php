<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run()
    // {
    //     $departments = Department::all();

    //     foreach ($departments as $department) {
    //         for ($i = 0; $i < 3; $i++) {
    //             $staff = User::firstOrCreate([
    //                 'school_id' => 'staff_' . $department->id . '_' . $i,
    //                 'email' => 'staff_' . $i . '@' . strtolower($department->name) . '.com',
    //                 'name' => 'Staff Member ' . $i . ' - ' . $department->name,
    //             ], [
    //                 'password' => Hash::make('password'),
    //             ]);

    //             $staff->assignRole('staff');
    //             $staff->departments()->syncWithoutDetaching([$department->id]);
    //         }
    //     }
    // }

    public function run()
    {
        $departments = Department::all();

        foreach ($departments as $department) {
            for ($i = 0; $i < 3; $i++) {
                $staff = User::create([
                    'name' => "Staff Member {$i} - {$department->name}",
                    'school_id' => "STAFF{$i}{$department->id}",
                    'email' => "staff{$i}@{$department->name}.com",
                    'password' => Hash::make('password123'),
                ]);

                // Assign the department
                $staff->department()->associate($department);
                $staff->save();

                // Assign the role
                $staff->assignRole('staff');
            }
        }
    }
}
