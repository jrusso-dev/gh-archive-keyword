<?php


namespace Yousign\Domain\Data\Response;

use Yousign\Domain\Data\Entity\Commit;
use stdClass;

/**
 * Class GetDataForDateResponse
 * @package Yousign\Domain\Data\Response
 */
class GetDataForDateResponse
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
     * @var int
     */
    private int $total = 0;

    /**
     * @var array
     */
    private array $dataByEventType = [];

    /**
     * @var Commit[]
     */
    private array $lastCommits = [];

    /**
     * GetDataForDateResponse constructor.
     * @param \DateTimeInterface $date
     * @param string $keyword
     */
    public function __construct(\DateTimeInterface $date, string $keyword)
    {
        $this->date = $date;
        $this->keyword = $keyword;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getKeyword(): string
    {
        return $this->keyword;
    }

    /**
     * @return array
     */
    public function getDataByEventType(): array
    {
        return $this->dataByEventType;
    }

    /**
     * @param string $eventType
     */
    public function initDataByEventType(string $eventType): void
    {
        $prototype = new stdClass();
        $prototype->total = 0;

        for($hour=0;$hour <= 23; $hour++) {
            $prototype->$hour = 0;
        }
        $this->dataByEventType[$eventType] = $prototype;
    }

    /**
     * @param string $eventType
     * @param int $hour
     */
    public function increaseDataForEventType(string $eventType, int $hour): void
    {
        if(!isset($this->dataByEventType[$eventType])) {
            $this->initDataByEventType($eventType);
        }
        $this->dataByEventType[$eventType]->$hour += 1;
        $this->dataByEventType[$eventType]->total += 1;
        $this->total += 1;
    }

    /**
     * @return Commit[]
     */
    public function getLastCommits(): array
    {
        return $this->lastCommits;
    }

    /**
     * @param Commit[] $lastCommits
     */
    public function setLastCommits(array $lastCommits): void
    {
        $this->lastCommits = $lastCommits;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }
}
