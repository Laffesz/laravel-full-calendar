<?php

declare(strict_types=1);

namespace LaravelFullCalendar;

use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Illuminate\View\View;

class Calendar
{
    protected Factory $view;

    protected EventCollection $eventCollection;

    protected string $id;

    /**
     * Default options array
     * @param array<string, array|bool> $items
     */
    protected array $defaultOptions = [
        'header' => [
            'left' => 'prev,next today',
            'center' => 'title',
            'right' => 'month,agendaWeek,agendaDay',
        ],
        'eventLimit' => true,
    ];

    /**
     * User defined options
     */
    protected array $userOptions = [];

    /**
     * User defined callback options
     */
    protected array $callbacks = [];

    public function __construct(Factory $view, EventCollection $eventCollection)
    {
        $this->view = $view;
        $this->eventCollection = $eventCollection;
    }

    /**
     * Create an event DTO to add to a calendar
     */
    public static function event(
        string $title,
        bool $isAllDay,
        string|\DateTime $start,
        string|\DateTime $end,
        string $id = null,
        array $options = []
    ): SimpleEvent {
        return new SimpleEvent($title, $isAllDay, $start, $end, $id, $options);
    }

    /**
     * Create the <div> the calendar will be rendered into
     */
    public function calendar(): string
    {
        return '<div id="calendar-' . $this->getId() . '"></div>';
    }

    /**
     * Get the <script> block to render the calendar (as a View)
     */
    public function script(): View
    {
        $options = $this->getOptionsJson();

        return $this->view->make('fullcalendar::script', [
            'id' => $this->getId(),
            'options' => $options,
        ]);
    }

    /**
     * Customize the ID of the generated <div>
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the ID of the generated <div>
     * This value is randomized unless a custom value was set via setId
     */
    public function getId(): string
    {
        if (!empty($this->id)) {
            return $this->id;
        }

        $this->id = Str::random(8);

        return $this->id;
    }

    /**
     * Add an event
     */
    public function addEvent(Event $event, array $customAttributes = []): self
    {
        $this->eventCollection->push($event, $customAttributes);

        return $this;
    }

    /**
     * Add multiple events
     */
    public function addEvents(array|\ArrayAccess $events, array $customAttributes = []): self
    {
        foreach ($events as $event) {
            $this->eventCollection->push($event, $customAttributes);
        }

        return $this;
    }

    /**
     * Set fullcalendar options
     */
    public function setOptions(array $options): self
    {
        $this->userOptions = $options;

        return $this;
    }

    /**
     * Get the fullcalendar options (not including the events list)
     */
    public function getOptions(): array
    {
        return array_merge($this->defaultOptions, $this->userOptions);
    }

    /**
     * Set fullcalendar callback options
     */
    public function setCallbacks(array $callbacks): self
    {
        $this->callbacks = $callbacks;

        return $this;
    }

    /**
     * Get the callbacks currently defined
     */
    public function getCallbacks(): array
    {
        return $this->callbacks;
    }

    /**
     * Get options+events JSON
     */
    public function getOptionsJson(): string
    {
        $options = $this->getOptions();
        $placeholders = $this->getCallbackPlaceholders();
        $parameters = array_merge($options, $placeholders);

        // Allow the user to override the events list with a url
        if (!isset($parameters['events'])) {
            $parameters['events'] = $this->eventCollection->toArray();
        }

        $json = json_encode($parameters);

        if ($placeholders) {
            return $this->replaceCallbackPlaceholders($json, $placeholders);
        }

        return $json;
    }

    /**
     * Generate placeholders for callbacks, will be replaced after JSON encoding
     */
    protected function getCallbackPlaceholders(): array
    {
        $callbacks = $this->getCallbacks();
        $placeholders = [];

        foreach ($callbacks as $name => $callback) {
            $placeholders[$name] = '[' . md5($callback) . ']';
        }

        return $placeholders;
    }

    /**
     * Replace placeholders with non-JSON encoded values
     */
    protected function replaceCallbackPlaceholders(string $json, array $placeholders): string
    {
        $search = [];
        $replace = [];

        foreach ($placeholders as $name => $placeholder) {
            $search[] = '"' . $placeholder . '"';
            $replace[] = $this->getCallbacks()[$name];
        }

        return Str::replaceArray($search, $replace, $json);
    }
}
