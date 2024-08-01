<?php

namespace App\Providers;

use App\Models\User;
use App\Smark\Arrayer;
use App\Smark\Dater;
use App\Smark\Encryption;
use App\Smark\Excel;
use App\Smark\File;
use App\Smark\HTML;
use App\Smark\JSON;
use App\Smark\Logging;
use App\Smark\Mail;
use App\Smark\Math;
use App\Smark\Payment;
use App\Smark\PDFer;
use App\Smark\Stringer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Math::class, function ($app) { return Math::class; });
        $this->app->singleton(Excel::class, function ($app) { return Excel::class; });
        $this->app->singleton(PDFer::class, function ($app) { return PDFer::class; });
        $this->app->singleton(HTML::class, function ($app) { return HTML::class; });
        $this->app->singleton(JSON::class, function ($app) { return JSON::class; });
        $this->app->singleton(Mail::class, function ($app) { return Mail::class; });
        $this->app->singleton(File::class, function ($app) { return File::class; });
        $this->app->singleton(Logging::class, function ($app) { return Logging::class; });
        $this->app->singleton(Payment::class, function ($app) { return Payment::class; });
        $this->app->singleton(Dater::class, function ($app) { return Dater::class; });
        $this->app->singleton(Encryption::class, function ($app) { return Encryption::class; });
        $this->app->singleton(Stringer::class, function ($app) { return Stringer::class; });
        $this->app->singleton(Arrayer::class, function ($app) { return Arrayer::class; });
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
