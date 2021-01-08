<?php


namespace App\Infrastructure\Adapter\Data\Gateway;


use Yousign\Domain\Data\Entity\Commit;
use Yousign\Domain\Data\Gateway\CommitGatewayInterface;


class CommitGateway implements CommitGatewayInterface
{

    /**
     * @param \DateTimeInterface $date
     * @return array
     */
    public function getCommitsForDate(\DateTimeInterface $date): array
    {
        if ($date->format('Y-m-d') === '2020-12-01') {
            return [1,3];
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
}
