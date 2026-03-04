<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Blog;
use App\Models\Listing;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a static sitemap.xml file for the website.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        $sitemap = Sitemap::create();

        // 1. Static Pages
        $sitemap->add(Url::create(route('home'))
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        $sitemap->add(Url::create(route('contact.create'))
            ->setPriority(0.8)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        $sitemap->add(Url::create(route('blog.list'))
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        // 2. Blog Posts
        Blog::query()
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->chunk(100, function ($blogs) use ($sitemap) {
                foreach ($blogs as $blog) {
                    $sitemap->add(Url::create(route('blog.show', $blog->slug))
                        ->setLastModificationDate($blog->updated_at)
                        ->setPriority(0.7)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
                }
            });

        // 3. Property Listings (Where status = approved)
        Listing::query()
            ->where('status', 'approved')
            ->chunk(100, function ($listings) use ($sitemap) {
                foreach ($listings as $listing) {
                    $sitemap->add(Url::create(route('listing.show', $listing->id))
                        ->setLastModificationDate($listing->updated_at)
                        ->setPriority(0.8)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
                }
            });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully in public/sitemap.xml');
    }
}
