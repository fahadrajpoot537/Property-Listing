<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $roles = [
            'admin',
            'manager',
            'listing director',
            'Q/A',
            'Agency',
            'Freelance',
            'landlords',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create a default admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@findauk.com'],
            [
                'name' => 'Super Admin',
                'username' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        $admin->assignRole('admin');
    }
}
