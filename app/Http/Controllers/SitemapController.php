<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Listing;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    /**
     * Generate dynamic sitemap.xml
     */
    public function index()
    {
        return Cache::remember('sitemap-dynamic', 3600, function () {
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

            return $sitemap->toResponse(request());
        });
    }
}
