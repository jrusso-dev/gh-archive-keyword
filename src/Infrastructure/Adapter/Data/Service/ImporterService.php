<?php


namespace App\Infrastructure\Adapter\Data\Service;


use Yousign\Domain\Data\Service\GitHubArchiveImporterServiceInterface;

/**
 * Class ImporterService
 * @package App\Infrastructure\Adapter\Data\Service
 */
class ImporterService implements GitHubArchiveImporterServiceInterface
{

    /**
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $date;

    /**
     * @var int
     */
    private int $hour;

    /**
     * @param \DateTimeInterface $date
     */
    public function setDateToImport(\DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    /**
     * @param int $hour
     */
    public function setHourToImport(int $hour): void
    {
        $this->hour = $hour;
    }

    /**
     * @return string
     */
    public function getRemoteFileName(): string
    {
        $dateString = $this->date->format('Y-m-d');
        return "$dateString-$this->hour";
    }
}
