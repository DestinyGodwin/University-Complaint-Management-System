<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = ['admin', 'staff', 'student'];
        $permissions = [
            'manage complaints',
            'assign complaints',
            'resolve complaints',
            'escalate complaints',
            'comment on complaints',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        foreach ($roles as $role) {
            $roleModel = Role::firstOrCreate(['name' => $role]);
            if ($role === 'admin') {
                $roleModel->givePermissionTo(Permission::all());
            } elseif ($role === 'staff') {
                $roleModel->givePermissionTo([
                    'resolve complaints',
                    'escalate complaints',
                    'comment on complaints',
                ]);
            }
        }
    }
}
