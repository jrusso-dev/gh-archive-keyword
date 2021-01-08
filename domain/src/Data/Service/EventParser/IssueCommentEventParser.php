<?php


namespace Yousign\Domain\Data\Service\EventParser;

use stdClass;

/**
 * Class IssueCommentEventParser
 * @package Yousign\Domain\Data\Service\EventParser
 */
class IssueCommentEventParser extends EventParserFactory
{
    public function parseEvent(): void
    {
        $event = $this->event;
        $this->initFormattedEvent();
        $this->setMessage((string)$event->payload->comment->body);
        $this->addFormattedEvent();
    }
}
