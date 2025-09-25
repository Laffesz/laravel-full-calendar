<?php

declare(strict_types=1);

namespace LaravelFullCalendar;

interface Event
{
    /**
     * Get the event's title
     */
    public function getTitle(): string;

    /**
     * Is it an all day event?
     */
    public function isAllDay(): bool;

    /**
     * Get the start time
     */
    public function getStart(): \DateTime;

    /**
     * Get the end time
     */
    public function getEnd(): \DateTime;
}
