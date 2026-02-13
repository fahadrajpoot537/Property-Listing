<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data provided by the user
        $userData = [
            'name' => 'Super Admin',
            'username' => 'Super Admin',
            'email' => 'info@propertyfinda.co.uk',
            'address' => '5-7 High St, London E13 0AD, UK',
            'latitude' => '51.5311527',
            'longitude' => '0.0196716',
            'phone_number' => '+442034113603',
            'email_verified_at' => '2026-02-13 11:05:47',
            'status' => 'document_approved',
            'created_at' => '2026-01-20 09:48:43',
            'updated_at' => '2026-02-13 11:05:47',
            'agency_id' => null,
            'id_card' => null,
            'passport' => null,
            'company_details' => null,
            'slug' => null,
        ];

        // Since the password hash provided was truncated, 
        // we use a secure default password. Change this immediately!
        // The original hash was: $2y$12$BU9x.qQFqpsHUY2Pn5Ewc.LykvaFYWIJntmIo94aa6n...
        $userData['password'] = Hash::make('Admin@123');

        User::updateOrCreate(
            ['id' => 1],
            $userData
        );

        // Ensure the user has the admin role
        $admin = User::find(1);
        if ($admin && !$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
