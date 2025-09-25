<?php

declare(strict_types=1);

namespace LaravelFullCalendar;

use DateTime;

/**
 * Class SimpleEvent
 *
 * Simple DTO that implements the Event interface
 *
 * @package Qlick\LaravelFullcalendar
 */
class SimpleEvent implements IdentifiableEvent
{
    public string|int|null $id;

    public string $title;

    public bool $isAllDay;

    public \DateTime $start;

    public \DateTime $end;

    private array $options;

    /**
     * @param string $title
     * @param bool $isAllDay
     * @param string|\DateTime $start If string, must be valid datetime format: http://bit.ly/1z7QWbg
     * @param string|\DateTime $end If string, must be valid datetime format: http://bit.ly/1z7QWbg
     * @param int|string|null $id
     * @param array $options
     */
    public function __construct(string $title, bool $isAllDay, string|\DateTime $start, string|\DateTime $end, int|string|null $id = null, array $options = [])
    {
        $this->title = $title;
        $this->isAllDay = $isAllDay;
        $this->start = $start instanceof \DateTime ? $start : new \DateTime($start);
        $this->end = $start instanceof \DateTime ? $end : new \DateTime($end);
        $this->id = $id;
        $this->options = $options;
    }

    /**
     * Get the event's id number
     */
    public function getId(): int|string|null
    {
        return $this->id;
    }

    /**
     * Get the event's title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Is it an all day event?
     */
    public function isAllDay(): bool
    {
        return $this->isAllDay;
    }

    /**
     * Get the start time
     */
    public function getStart(): \DateTime
    {
        return $this->start;
    }

    /**
     * Get the end time
     */
    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    /**
     * Get the optional event options
     */
    public function getEventOptions(): array
    {
        return $this->options;
    }
}
