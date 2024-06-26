<?php

namespace App\Repository;

use App\Entity\Height;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Height>
 *
 * @method Height|null find($id, $lockMode = null, $lockVersion = null)
 * @method Height|null findOneBy(array $criteria, array $orderBy = null)
 * @method Height[]    findAll()
 * @method Height[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HeightRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Height::class);
    }

    public function findByHealthContainer($healthContainer): array
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.healthContainer = :val')
            ->setParameter('val', $healthContainer)
            ->orderBy('h.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
