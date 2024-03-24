<?php

namespace App\Repository;

use App\Entity\DatesContainer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DatesContainer>
 *
 * @method DatesContainer|null find($id, $lockMode = null, $lockVersion = null)
 * @method DatesContainer|null findOneBy(array $criteria, array $orderBy = null)
 * @method DatesContainer[]    findAll()
 * @method DatesContainer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatesContainerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DatesContainer::class);
    }

    //    /**
    //     * @return DatesContainer[] Returns an array of DatesContainer objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DatesContainer
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
