<?php


namespace Yousign\Domain\Data\Entity;

use stdClass;

/**
 * Class Commit
 * @package Yousign\Domain\Data\Entity
 */
class Commit
{

    const CREATE_EVT = 'CreateEvent';
    const COMMIT_COMMENT_EVT = 'CommitCommentEvent';
    const ISSUE_COMMENT_EVT = 'IssueCommentEvent';
    const PUSH_EVT = 'PushEvent';

    const EVENTS_TO_MANAGE = [
        self::CREATE_EVT,
        self::COMMIT_COMMENT_EVT,
        self::ISSUE_COMMENT_EVT,
        self::PUSH_EVT
    ];

    /**
     * @var string
     */
    private string $commitId;

    /**
     * @var string
     */
    private string $commitType;

    /**
     * @var string
     */
    private string $repositoryName;

    /**
     * @var string
     */
    private string $repositoryUrl;

    /**
     * @var string
     */
    private string $message;

    /**
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $createdAt;

    /**
     * Commit constructor.
     * @param string $commitId
     * @param string $commitType
     * @param string $repositoryName
     * @param string $repositoryUrl
     * @param string $message
     * @param \DateTimeInterface $createdAt
     */
    public function __construct(
        string $commitId,
        string $commitType,
        string $repositoryName,
        string $repositoryUrl,
        string $message,
        \DateTimeInterface $createdAt
    ) {
        $this->commitId = $commitId;
        $this->commitType = $commitType;
        $this->repositoryName = $repositoryName;
        $this->repositoryUrl = $repositoryUrl;
        $this->message = $message;
        $this->createdAt = $createdAt;
    }


    public static function fromObject(stdClass $formattedEvent): self
    {
        $commitId = $formattedEvent->eventId;
        $type = $formattedEvent->eventType;
        $repositoryName = $formattedEvent->repoName;
        $repositoryUrl = $formattedEvent->repoUrl;
        $message = $formattedEvent->message;
        $createdAt = $formattedEvent->createdAt;

        return new self(
            $commitId,
            $type,
            $repositoryName,
            $repositoryUrl,
            $message,
            $createdAt
        );

    }

}
