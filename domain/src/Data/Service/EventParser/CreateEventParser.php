<?php


namespace Yousign\Domain\Data\Service\EventParser;

use stdClass;

/**
 * Class CreateEventParser
 * @package Yousign\Domain\Data\Service\EventParser
 */
class CreateEventParser extends EventParserFactory
{
    public function parseEvent(): void
    {
        $event = $this->event;
        $this->initFormattedEvent();
        $this->setMessage((string)$event->payload->description);
        $this->addFormattedEvent();
    }
}
