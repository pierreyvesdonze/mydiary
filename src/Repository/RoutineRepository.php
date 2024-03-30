<?php

namespace App\Repository;

use App\Entity\Routine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Routine>
 *
 * @method Routine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Routine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Routine[]    findAll()
 * @method Routine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoutineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Routine::class);
    }

    /**
     * @return Routine[] Returns an array of Mood objects
     */
    public function findByRoutineContainer($routineContainer): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.routineContainer = :val')
            ->setParameter('val', $routineContainer)
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
