<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Infrastructure\Entity\Commit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Yousign\Domain\Data\Entity\Commit as DomainCommit;
use Yousign\Domain\Data\Gateway\CommitGatewayInterface;


/**
 * @method Commit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commit[]    findAll()
 * @method Commit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommitRepository extends ServiceEntityRepository implements CommitGatewayInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commit::class);
    }

    // /**
    //  * @return Commit[] Returns an array of Commit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Commit
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @param \DateTimeInterface $date
     * @return array
     */
    public function getCommitsForDate(\DateTimeInterface $date): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.createdAt = :date')
            ->setParameter('date', $date)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param DomainCommit $commit
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(DomainCommit $commit): void
    {
        $doctrineCommit = new Commit();
        $doctrineCommit->setMessage($commit->getMessage())
            ->setCreatedAt($commit->getCreatedAt())
            ->setCommitId($commit->getCommitId())
            ->setCommitType($commit->getCommitType())
            ->setRepositoryName($commit->getRepositoryName())
            ->setRepositoryUrl($commit->getRepositoryUrl());

        $this->_em->persist($doctrineCommit);
        $this->_em->flush();

    }

    /**
     * @param \DateTimeInterface $date
     */
    public function removeCommitsFromDate(\DateTimeInterface $date): void
    {
        $this->createQueryBuilder('c')
            ->delete()
            ->andWhere('c.createdAt = :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->execute();
    }

    /**
     * @param array $commits
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\Persistence\Mapping\MappingException
     */
    public function createFromArray(array $commits): void
    {
        foreach($commits as $commit) {
            $doctrineCommit = new Commit();
            $doctrineCommit->setMessage($commit->getMessage())
                ->setCreatedAt($commit->getCreatedAt())
                ->setCommitId($commit->getCommitId())
                ->setCommitType($commit->getCommitType())
                ->setRepositoryName($commit->getRepositoryName())
                ->setRepositoryUrl($commit->getRepositoryUrl());

            $this->_em->persist($doctrineCommit);
        }
        $this->_em->flush();
        $this->_em->clear();
    }

    /**
     * @param \DateTimeInterface $date
     * @param int $numberOfCommits
     * @param string|null $keyword
     * @return DomainCommit[]
     * @throws \Exception
     */
    public function getLastCommitsForDate(\DateTimeInterface $date, int $numberOfCommits = 10, string $keyword = ''): array
    {
        $from = new \DateTime($date->format("Y-m-d")." 00:00:00");
        $to   = new \DateTime($date->format("Y-m-d")." 23:59:59");
        $numberOfCommits = min($numberOfCommits, 100);
        $commits = $this->createQueryBuilder('c')
            ->andWhere('c.createdAt BETWEEN :from AND :to')
            ->andWhere('c.commitType = :type')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
            ->setParameter('type', DomainCommit::PUSH_EVT)
            ->orderBy('c.id', 'DESC')
            ->setMaxResults($numberOfCommits);

        if(!empty($keyword)) {
            $commits->andWhere('c.message LIKE :message')->setParameter('message', "%$keyword%");
        }

        $commits = $commits->getQuery()->getResult();

        $return = [];
        if(!empty($commits)) {
            return $this->getDomainCommitsFromCommits($commits);
        }
        return $return;
    }

    /**
     * @param \DateTimeInterface $date
     * @param string $keyword
     * @return DomainCommit[]
     * @throws \Exception
     */
    public function getCommitsForDateAndKeyword(\DateTimeInterface $date, string $keyword): array
    {
        $from = new \DateTime($date->format("Y-m-d")." 00:00:00");
        $to   = new \DateTime($date->format("Y-m-d")." 23:59:59");

        $commits = $this->createQueryBuilder('c')
            ->andWhere('c.createdAt BETWEEN :from AND :to')
            ->andWhere('c.message LIKE :message')
            ->setParameter('message', "%$keyword%")
            ->setParameter('from', $from )
            ->setParameter('to', $to)
            ->getQuery()
            ->getResult();

        $return = [];
        if(!empty($commits)) {
            return $this->getDomainCommitsFromCommits($commits);
        }
        return $return;
    }

    /**
     * @param array $commits
     * @return array
     */
    private function getDomainCommitsFromCommits(array $commits) : array
    {
        $return = [];
        foreach($commits as $commit) {
            /** @var Commit $commit */
            $return[] = $commit->getDomainEntity();
        }
        return $return;
    }
}
