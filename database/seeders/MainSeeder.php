<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'manage users',
            'manage roles',
            'manage listings',
            'manage off-market listings',
            'manage property types',

            'manage features',
            'access dashboard',
            'view affiliates'
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
        }

        // create roles and assign created permissions
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        $role->syncPermissions(\Spatie\Permission\Models\Permission::all());

        $agentRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'agent']);
        $agentRole->syncPermissions(['manage listings', 'manage off-market listings', 'access dashboard']);

        $userRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'user']);

        // create admin user
        $user = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'phone_number' => '1234567890',
            'slug' => 'admin-user'
        ]);
        $user->assignRole($role);

        // create Property Types
        $residential = \App\Models\PropertyType::firstOrCreate(['title' => 'Residential'], ['slug' => 'residential']);
        $commercial = \App\Models\PropertyType::firstOrCreate(['title' => 'Commercial'], ['slug' => 'commercial']);
        $land = \App\Models\PropertyType::firstOrCreate(['title' => 'Land'], ['slug' => 'land']);



        // create Features
        $features = ['Swimming Pool', 'Gym', 'Parking', 'Security', 'Balcony', 'Garden', 'Elevator', 'Central AC'];
        foreach ($features as $feature) {
            \App\Models\Feature::firstOrCreate(['title' => $feature], ['slug' => \Illuminate\Support\Str::slug($feature)]);
        }
    }
}
