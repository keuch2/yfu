<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $storagePath = "/home/yfuorgpy/storagedir";
        if (is_dir($storagePath)) {
            $this->app->useStoragePath($storagePath);
        }
    }

    public function boot(): void
    {
        if ($this->app->environment("production")) {
            \Illuminate\Support\Facades\URL::forceScheme("https");
        }
    }
}
