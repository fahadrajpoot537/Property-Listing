<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Setting::set('affiliate_rate', '5', 'affiliate', 'Payment amount per batch of visitors');
        \App\Models\Setting::set('affiliate_batch_size', '1000', 'affiliate', 'Number of unique visitors required for payment');
    }
}
