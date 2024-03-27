<?php

namespace App\Repository;

use App\Entity\Vaccine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vaccine>
 *
 * @method Vaccine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vaccine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vaccine[]    findAll()
 * @method Vaccine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VaccineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vaccine::class);
    }

    public function findByHealthContainer($healthContainer): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.healthContainer = :val')
            ->setParameter('val', $healthContainer)
            ->orderBy('v.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
