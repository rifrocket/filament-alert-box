<?php

namespace RifRocket\FilamentAlertBox;

use Illuminate\Support\ServiceProvider;

class AlertBoxServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // No singleton registration needed for static class
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'alert-box');  
        // No CSS assets needed - using Tailwind CSS utility classes only
    }
}
