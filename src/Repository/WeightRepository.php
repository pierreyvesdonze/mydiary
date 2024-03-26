<?php

namespace App\Repository;

use App\Entity\Weight;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Weight>
 *
 * @method Weight|null find($id, $lockMode = null, $lockVersion = null)
 * @method Weight|null findOneBy(array $criteria, array $orderBy = null)
 * @method Weight[]    findAll()
 * @method Weight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeightRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Weight::class);
    }

    public function findByHealthContainer($healthContainer): array
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.healthContainer = :val')
            ->setParameter('val', $healthContainer)
            ->orderBy('w.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
