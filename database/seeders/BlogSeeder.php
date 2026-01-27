<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::create([
            'title' => 'Introduction to Real Estate Investment',
            'content' => '<p>Real estate investment can be a lucrative way to build wealth over time. In this blog post, we will explore the fundamentals of real estate investment, including different types of properties, market analysis, financing options, and strategies for success.</p><p>Real estate investment involves purchasing, owning, managing, renting, or selling real estate for profit. This can include residential properties like houses and apartments, commercial properties like office buildings and retail spaces, or industrial properties like warehouses and factories.</p>',
        ]);

        Blog::create([
            'title' => 'Tips for First-Time Home Buyers',
            'content' => '<p>Buying your first home is an exciting milestone, but it can also be overwhelming. Here are some essential tips to help you navigate the process smoothly:</p><ul><li>Determine your budget and get pre-approved for a mortgage</li><li>Research neighborhoods and property values</li><li>Hire a qualified real estate agent</li><li>Get a home inspection before closing</li><li>Consider additional costs like taxes, insurance, and maintenance</li></ul>',
        ]);

        Blog::create([
            'title' => 'Understanding Property Valuation Methods',
            'content' => '<p>Property valuation is a crucial aspect of real estate transactions. There are several methods to determine the value of a property:</p><ol><li>Comparable Sales Method: Comparing the property to similar recently sold properties</li><li>Cost Approach: Estimating the cost to rebuild the property</li><li>Income Capitalization Approach: Analyzing the income potential of the property</li></ol><p>Each method has its advantages and is suitable for different types of properties and situations.</p>',
        ]);
    }
}
