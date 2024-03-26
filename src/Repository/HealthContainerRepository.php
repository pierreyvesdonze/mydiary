<?php

namespace App\Repository;

use App\Entity\HealthContainer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HealthContainer>
 *
 * @method HealthContainer|null find($id, $lockMode = null, $lockVersion = null)
 * @method HealthContainer|null findOneBy(array $criteria, array $orderBy = null)
 * @method HealthContainer[]    findAll()
 * @method HealthContainer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HealthContainerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HealthContainer::class);
    }

    //    /**
    //     * @return HealthContainer[] Returns an array of HealthContainer objects
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

    //    public function findOneBySomeField($value): ?HealthContainer
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
