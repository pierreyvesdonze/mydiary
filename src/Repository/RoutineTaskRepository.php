<?php

namespace App\Repository;

use App\Entity\RoutineTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RoutineTask>
 *
 * @method RoutineTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoutineTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoutineTask[]    findAll()
 * @method RoutineTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoutineTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoutineTask::class);
    }

    //    /**
    //     * @return RoutineTask[] Returns an array of RoutineTask objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RoutineTask
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
