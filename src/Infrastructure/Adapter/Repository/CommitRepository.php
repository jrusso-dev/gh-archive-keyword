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

    public function findOneByRegistrationCode($registrationCode)
    {
        return $this->findOneBy(['registrationCode' => $registrationCode]);
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
     * @return array
     */
    public function getLastCommitsForDate(\DateTimeInterface $date, int $numberOfCommits): array
    {
        $numberOfCommits = min($numberOfCommits, 100);
        return $this->createQueryBuilder('c')
            ->andWhere('c.createdAt = :date')
            ->setParameter('date', $date)
            ->orderBy('c.id', 'DESC')
            ->setMaxResults($numberOfCommits)
            ->getQuery()
            ->getResult();
    }
}
