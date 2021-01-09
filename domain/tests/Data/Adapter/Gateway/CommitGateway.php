<?php


namespace Yousign\Domain\Tests\Data\Adapter\Gateway;


use DateTime;
use Yousign\Domain\Data\Entity\Commit;
use Yousign\Domain\Data\Gateway\CommitGatewayInterface;

/**
 * Class CommitGateway
 * @package Yousign\Domain\Tests\Data\Adapter\Gateway
 */
class CommitGateway implements CommitGatewayInterface
{

    /**
     * @param \DateTimeInterface $date
     * @return array
     */
    public function getCommitsForDate(\DateTimeInterface $date): array
    {
        if ($date->format('Y-m-d') === '2020-12-01') {
            return [1, 3];
        }

        return [];
    }

    /**
     * @param Commit $commit
     */
    public function create(Commit $commit): void
    {
        // TODO: Implement create() method.
    }

    /**
     * @param \DateTimeInterface $date
     */
    public function removeCommitsFromDate(\DateTimeInterface $date): void
    {
        // TODO: Implement removeCommitsFromDate() method.
    }

    /**
     * @param array $commits
     */
    public function createFromArray(array $commits): void
    {
        // TODO: Implement createFromArray() method.
    }

    /**
     * @param \DateTimeInterface $date
     * @param int $numberOfCommits
     * @param string $keyword
     * @return Commit[]
     * @throws \Exception
     */
    public function getLastCommitsForDate(\DateTimeInterface $date, int $numberOfCommits, string $keyword = 'love'): array
    {
        if ($date->format('Y-m-d') === '2020-12-01' && $keyword === 'love') {
            return [
                new Commit(
                    "12345",
                    "PushEvent",
                    "myrepo/myrepo",
                    "repoURL",
                    "Lots of fun and lots of love",
                    new DateTime("2020-12-01 23:59:59")
                ),
            ];
        }

        return [];
    }

    /**
     * @param \DateTimeInterface $date
     * @param string $keyword
     * @return Commit[]
     * @throws \Exception
     */
    public function getCommitsForDateAndKeyword(\DateTimeInterface $date, string $keyword): array
    {
        return $this->getLastCommitsForDate($date,1, $keyword);
    }
}
