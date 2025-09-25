<?php

declare(strict_types=1);

namespace LaravelFullCalendar;

use Illuminate\Support\ServiceProvider;

class FullCalendarServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind('laravel-full-calendar', static function ($app) {
            return $app->make('LaravelFullCalendar\Calendar');
        });
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__, 'fullcalendar');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['laravel-full-calendar'];
        //return ['laravel-full-calendar', Calendar::class];
    }
}
