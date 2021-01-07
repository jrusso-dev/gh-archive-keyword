<?php


namespace Yousign\Domain\Data\Request;

use Assert\Assertion;

/**
 * Class ImportFromGhArchiveRequest
 * @package Yousign\Domain\Data\Request
 */
class ImportFromGhArchiveRequest
{
    const MIN_YEAR = 2012;
    const MAX_MONTH = 12;
    const MAX_DAY = 31;

    const DATE_FORMAT = 'Y-m-d';

    /**
     * @var int
     */
    private int $year;

    /**
     * @var int
     */
    private int $month;

    /**
     * @var int
     */
    private int $day;

    /**
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $date;

    /**
     * @var bool
     */
    private $replaceData = false;

    public function __construct(
      int $year,
      int $month,
      int $day,
      ?bool $replaceData
    ){
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        if(!is_null($replaceData)) {
            $this->replaceData = $replaceData;
        }
        $dateAsString = $this->getDateAsString();
        $this->setDate(\DateTime::createFromFormat(self::DATE_FORMAT, $dateAsString));

    }

    public static function create(
        int $year,
        int $month,
        int $day,
        ?bool $replaceData = null
    ): self {
        return new self($year, $month, $day, $replaceData);
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getDay(): int
    {
        return $this->day;
    }

    /**
     * @return bool
     */
    public function getReplaceData(): bool
    {
        return $this->replaceData;
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

    public function validate()
    {
        Assertion::notBlank($this->year);
        Assertion::notBlank($this->month);
        Assertion::notBlank($this->day);
        Assertion::greaterOrEqualThan($this->year, self::MIN_YEAR);
        Assertion::lessOrEqualThan($this->month, self::MAX_MONTH);
        Assertion::lessOrEqualThan($this->day, self::MAX_DAY);
        Assertion::true($this->checkIfDateFormatIsValid());
        Assertion::true($this->checkIfDateIsPast());
    }

    private function getDateAsString() : string
    {
        $day = $this->day < 10 ? "0$this->day" : $this->day;
        return "$this->year-$this->month-$day";
    }

    private function checkIfDateFormatIsValid(): bool
    {
        $dateString = $this->getDateAsString();
        $dateObject = $this->getDate();
        return $dateObject && $dateObject->format('Y-m-d') === $dateString;
    }

    private function checkIfDateIsPast(): bool
    {
        $dateObject = $this->getDate();
        $nowDateObject = new \DateTime();
        return $dateObject <= $nowDateObject;
    }


}
