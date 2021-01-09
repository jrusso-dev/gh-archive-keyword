<?php


namespace App\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;
use Yousign\Domain\Data\Entity\Commit as DomainCommit;

/**
 * Class Commit
 * @package App\Infrastructure\Entity
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\CommitRepository")
 * @ORM\Table(name="commit", indexes={
 *     @ORM\Index(name="idx_created_at", columns={"created_at"})
 * })
 */
class Commit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $commitId;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $commitType;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $repositoryName;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $repositoryUrl;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private string $message;

    /**
     * @ORM\Column(type="date")
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $createdAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCommitId(): string
    {
        return $this->commitId;
    }

    /**
     * @param string $commitId
     * @return Commit
     */
    public function setCommitId(string $commitId): self
    {
        $this->commitId = $commitId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCommitType(): string
    {
        return $this->commitType;
    }

    /**
     * @param string $commitType
     * @return Commit
     */
    public function setCommitType(string $commitType): self
    {
        $this->commitType = $commitType;

        return $this;
    }

    /**
     * @return string
     */
    public function getRepositoryName(): string
    {
        return $this->repositoryName;
    }

    /**
     * @param string $repositoryName
     * @return Commit
     */
    public function setRepositoryName(string $repositoryName): self
    {
        $this->repositoryName = $repositoryName;

        return $this;
    }

    /**
     * @return string
     */
    public function getRepositoryUrl(): string
    {
        return $this->repositoryUrl;
    }

    /**
     * @param string $repositoryUrl
     * @return Commit
     */
    public function setRepositoryUrl(string $repositoryUrl): self
    {
        $this->repositoryUrl = $repositoryUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Commit
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     * @return Commit
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DomainCommit
     */
    public function getDomainEntity()
    {
        return new DomainCommit(
            $this->commitId,
            $this->commitType,
            $this->repositoryName,
            $this->repositoryUrl,
            $this->message,
            $this->createdAt
        );
    }
}
