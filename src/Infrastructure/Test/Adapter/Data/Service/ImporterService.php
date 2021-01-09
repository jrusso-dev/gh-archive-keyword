<?php


namespace App\Infrastructure\Test\Adapter\Data\Service;

use Yousign\Domain\Data\Service\GitHubArchiveImporterServiceInterface;

/**
 * Class ImporterService
 * @package App\Infrastructure\Test\Adapter\Data\Service
 */
class ImporterService implements GitHubArchiveImporterServiceInterface
{

    /**
     * @param \DateTimeInterface $date
     */
    public function setDateToImport(\DateTimeInterface $date): void
    {
        // TODO: Implement setDateToImport() method.
    }

    /**
     * @param int $hour
     */
    public function setHourToImport(int $hour): void
    {
        // TODO: Implement setHourToImport() method.
    }

    /**
     * @return string
     */
    public function getRemoteFileName(): string
    {
        return '';
    }
}
