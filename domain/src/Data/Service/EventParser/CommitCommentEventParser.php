<?php


namespace Yousign\Domain\Data\Service\EventParser;

use stdClass;

/**
 * Class CommitCommentEventParser
 * @package Yousign\Domain\Data\Service\EventParser
 */
class CommitCommentEventParser extends EventParserFactory
{
    public function parseEvent(): void
    {
        $event = $this->event;
        $this->initFormattedEvent();
        $this->setMessage((string)$event->payload->comment->body);
        $this->addFormattedEvent();
    }
}
