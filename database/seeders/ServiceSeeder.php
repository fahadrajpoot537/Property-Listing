<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'title' => 'Property Valuation',
            'description' => 'Professional property valuation services to determine the fair market value of your property. Our certified appraisers use industry-standard methods to provide accurate valuations for various purposes including sales, refinancing, and investment decisions.',
        ]);

        Service::create([
            'title' => 'Property Management',
            'description' => 'Comprehensive property management services to help you maximize your rental income while minimizing stress. We handle tenant screening, maintenance coordination, rent collection, and property marketing.',
        ]);

        Service::create([
            'title' => 'Real Estate Consulting',
            'description' => 'Expert consulting services for all your real estate needs. From investment advice to market analysis, our experienced consultants provide tailored solutions to help you achieve your property goals.',
        ]);

        Service::create([
            'title' => 'Home Staging',
            'description' => "Transform your property into an attractive space that appeals to potential buyers. Our professional staging services enhance your property's appeal and help it sell faster and for a higher price.",
        ]);
    }
}