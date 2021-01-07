<?php


namespace Yousign\Domain\Data\Entity;

use stdClass;

/**
 * Class Commit
 * @package Yousign\Domain\Data\Entity
 */
class Commit
{

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
    private string $repository;

    /**
     * @var string
     */
    private string $repositoryUrl;

    /**
     * @var string
     */
    private string $description;

    /**
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $createdAt;

    /**
     * Commit constructor.
     * @param string $commitId
     * @param string $commitType
     * @param string $repository
     * @param string $repositoryUrl
     * @param string $description
     * @param \DateTimeInterface $createdAt
     */
    public function __construct(
        string $commitId,
        string $commitType,
        string $repository,
        string $repositoryUrl,
        string $description,
        \DateTimeInterface $createdAt
    ) {
        $this->commitId = $commitId;
        $this->commitType = $commitType;
        $this->repository = $repository;
        $this->repositoryUrl = $repositoryUrl;
        $this->description = $description;
        $this->createdAt = $createdAt;
    }


    public static function fromObject(stdClass $object): self
    {
        $commitId = $object->id;
        $type = $object->type;
        $repository = $object->repo->name;
        $repositoryUrl = $object->repo->url;
        $description = $object->payload->description;
        $createdAt = new \DateTime($object->created_at);

        return new self(
            $commitId,
            $type,
            $repository,
            $repositoryUrl,
            $description,
            $createdAt
        );

    }

}
