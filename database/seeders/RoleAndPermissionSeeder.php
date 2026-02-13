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

        // define permissions
        $permissions = [
            'dashboard.view',

            // User Management
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

            // Role Management
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',

            // Permission Management
            'permission.view',
            'permission.create',
            'permission.edit',
            'permission.delete',

            // Listing Management
            'listing.view',
            'listing.create',
            'listing.edit',
            'listing.delete',
            'listing.approve',

            // Off Market Listing Management
            'off-market.view',
            'off-market.create',
            'off-market.edit',
            'off-market.delete',
            'off-market.approve',

            // Blog Management
            'blog.view',
            'blog.create',
            'blog.edit',
            'blog.delete',

            // Settings
            'setting.view',
            'setting.edit',

            // Asset Management (Property Types, Locations, etc.)
            'asset.manage',

            // Content Management (Services, Contact, Emails)
            'content.manage',

            // Partner/Affiliate
            'partner.view',
            'partner.approve',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

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

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Assign all permissions to admin
            if ($roleName === 'admin') {
                $role->syncPermissions(Permission::all());
            }

            // Assign specific permissions to other roles (example)
            if ($roleName === 'manager') {
                $role->syncPermissions([
                    'dashboard.view',
                    'user.view',
                    'listing.view',
                    'listing.edit',
                    'listing.approve',
                    'off-market.view',
                    'off-market.edit',
                    'blog.view',
                    'blog.create',
                    'blog.edit',
                ]);
            }

            if ($roleName === 'listing director') {
                $role->syncPermissions([
                    'dashboard.view',
                    'listing.view',
                    'listing.create',
                    'listing.edit',
                    'listing.delete',
                    'listing.approve',
                    'off-market.view',
                    'off-market.create',
                    'off-market.edit',
                    'off-market.delete',
                    'off-market.approve',
                ]);
            }
        }

        // Create a default admin user if not exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@findauk.com'],
            [
                'name' => 'Super Admin',
                'username' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        // Assign admin role to the user
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
