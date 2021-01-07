<?php


namespace Yousign\Domain\Data\Service;

/**
 * Interface GitHubArchiveImporterServiceInterface
 * @package Yousign\Domain\Data\Service
 */
interface GitHubArchiveImporterServiceInterface
{
    /**
     * @param \DateTimeInterface $date
     */
    public function setDateToImport(\DateTimeInterface $date): void;

    /**
     * @param int $hour
     */
    public function setHourToImport(int $hour): void;

    /**
     * @return string
     */
    public function getRemoteFileName(): string;
}
