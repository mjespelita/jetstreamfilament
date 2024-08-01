<?php

namespace App\Providers;

use App\Models\User;
use App\Smark\Smark;
use App\Smark\SmarkPDF;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Smark::class, function ($app) {
            return Smark::class;
        });

        $this->app->singleton(Smark::class, function ($app) {
            return SmarkPDF::class;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Laravel Pulse

        Gate::define('viewPulse', function (User $user) {
            return $user->role === 1;
        });
    }
}
