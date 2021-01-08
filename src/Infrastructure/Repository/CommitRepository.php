<?php

namespace App\Infrastructure\Repository;

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
        return [];
    }

    /**
     * @param DomainCommit $commit
     */
    public function create(DomainCommit $commit): void
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
