<?php

declare(strict_types=1);

namespace LaravelFullCalendar;

interface IdentifiableEvent extends Event
{
    /**
     * Get the event's ID
     */
    public function getId(): int|string|null;
}
