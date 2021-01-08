<?php


namespace Yousign\Domain\Data\Service\EventParser;

use stdClass;

/**
 * Class PushEventParser
 * @package Yousign\Domain\Data\Service\EventParser
 */
class PushEventParser extends EventParserFactory
{

    public function parseEvent(): void
    {
        $event = $this->event;
        foreach($event->payload->commits as $commit) {
            $this->initFormattedEvent();
            $this->setMessage((string)$commit->message);
            $this->addFormattedEvent();
        }
    }
}
