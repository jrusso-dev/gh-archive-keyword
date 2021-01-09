<?php


namespace Yousign\Domain\Data\Request;

/**
 * Class GetDataForDateRequest
 * @package Yousign\Domain\Data\Request
 */
class GetDataForDateRequest
{
    /**
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $date;

    /**
     * @var string
     */
    private string $keyword;

    /**
     * GetDataForDateRequest constructor.
     * @param \DateTimeInterface $date
     * @param string $keyword
     */
    public function __construct(
        \DateTimeInterface $date,
        string $keyword
    ) {
        $this->date = $date;
        $this->keyword = $keyword;
    }

    /**
     * @param \DateTimeInterface $date
     * @param string $keyword
     * @return GetDataForDateRequest
     */
    public static function create(
        \DateTimeInterface $date,
        string $keyword
    ): self {
        return new self($date, $keyword);
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     */
    public function setDate(\DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getKeyword(): string
    {
        return $this->keyword;
    }

    /**
     * @param string $keyword
     */
    public function setKeyword(string $keyword): void
    {
        $this->keyword = $keyword;
    }
}
