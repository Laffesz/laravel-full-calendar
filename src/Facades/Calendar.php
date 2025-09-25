<?php

declare(strict_types=1);

namespace LaravelFullCalendar\Facades;

use Illuminate\Support\Facades\Facade;

class Calendar extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-full-calendar';
    }
}
