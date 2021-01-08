<?php


namespace Yousign\Domain\Data\Service\EventParser;

use stdClass;

/**
 * Class EventParserFactory
 * @package Yousign\Domain\Data\Service\EventParser
 */
abstract class EventParserFactory
{
    /**
     * @var stdClass
     */
    protected stdClass $event;

    /**
     * @var array
     */
    protected array $formattedEvents = [];

    /**
     * @var stdClass
     */
    protected stdClass $formattedEvent;

    /**
     * EventParserFactory constructor.
     * @param stdClass $event
     */
    public function __construct(stdClass $event)
    {
        $this->event = $event;
        $this->initFormattedEvent();
        $this->parseEvent();
    }

    /**
     * @param stdClass $event
     * @return mixed
     */
    public static function fromEvent(stdClass $event)
    {
        $eventType = $event->type;
        $className = "Yousign\Domain\Data\Service\EventParser\\".$eventType."Parser";
        return new $className($event);
    }

    /**
     * @return array
     */
    public function getFormattedEvents(): array
    {
        return $this->formattedEvents;
    }

    protected function addFormattedEvent(): void
    {
        $this->formattedEvents[] = $this->formattedEvent;
    }

    protected function initFormattedEvent(): void
    {
        $event = $this->event;
        $formattedEvent = new stdClass();
        $formattedEvent->eventId = $event->id;
        $formattedEvent->eventType = $event->type;
        $formattedEvent->repoName = $event->repo->name;
        $formattedEvent->repoUrl = $event->repo->url;
        $formattedEvent->createdAt =  new \DateTime($event->created_at);
        $formattedEvent->message = '';
        $this->formattedEvent = $formattedEvent;
    }

    /**
     * @param string $message
     */
    protected function setMessage(string $message) : void
    {
        $this->formattedEvent->message = $message;
    }

    public abstract function parseEvent() : void;


}
