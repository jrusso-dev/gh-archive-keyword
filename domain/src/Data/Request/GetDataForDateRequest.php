<?php


namespace Yousign\Domain\Data\Request;

use Assert\Assertion;

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

    /**
     * @return bool
     * @throws \Exception
     */
    private function checkIfDateIsPast(): bool
    {
        $dateObject = $this->getDate();
        $nowDateObject = new \DateTime();
        return $dateObject <= $nowDateObject;
    }

    public function validate()
    {
        Assertion::notBlank($this->keyword);
        Assertion::minLength($this->keyword, 4);
        Assertion::true($this->checkIfDateIsPast());
    }
}
