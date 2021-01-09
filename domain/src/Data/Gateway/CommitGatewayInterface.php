<?php


namespace Yousign\Domain\Data\Gateway;

use Yousign\Domain\Data\Entity\Commit;

/**
 * Interface CommitGatewayInterface
 * @package Yousign\Domain\Data\Gateway
 */
interface CommitGatewayInterface
{
    /**
     * @param \DateTimeInterface $date
     * @return array
     */
    public function getCommitsForDate(\DateTimeInterface $date): array;

    /**
     * @param \DateTimeInterface $date
     * @param string $keyword
     * @return Commit[]
     */
    public function getCommitsForDateAndKeyword(\DateTimeInterface $date, string $keyword): array;

    /**
     * @param \DateTimeInterface $date
     * @param int $numberOfCommits
     * @param string $keyword
     * @return Commit[]
     */
    public function getLastCommitsForDate(\DateTimeInterface $date, int $numberOfCommits, string $keyword = ''): array;

    /**
     * @param Commit $commit
     */
    public function create(Commit $commit): void;

    /**
     * @param array $commits
     */
    public function createFromArray(array $commits): void;

    /**
     * @param \DateTimeInterface $date
     */
    public function removeCommitsFromDate(\DateTimeInterface $date): void;

}
