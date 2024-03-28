<?php

namespace App\Repository;

use App\Entity\HealthCondition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HealthCondition>
 *
 * @method HealthCondition|null find($id, $lockMode = null, $lockVersion = null)
 * @method HealthCondition|null findOneBy(array $criteria, array $orderBy = null)
 * @method HealthCondition[]    findAll()
 * @method HealthCondition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HealthConditionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HealthCondition::class);
    }

    //    /**
    //     * @return HealthCondition[] Returns an array of HealthCondition objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?HealthCondition
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
