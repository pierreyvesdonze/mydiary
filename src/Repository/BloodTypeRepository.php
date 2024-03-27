<?php

namespace App\Repository;

use App\Entity\BloodType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BloodType>
 *
 * @method BloodType|null find($id, $lockMode = null, $lockVersion = null)
 * @method BloodType|null findOneBy(array $criteria, array $orderBy = null)
 * @method BloodType[]    findAll()
 * @method BloodType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BloodTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BloodType::class);
    }

    public function findByHealthContainer($healthContainer): array
    {
        return $this->createQueryBuilder('bt')
            ->andWhere('bt.healthContainer = :val')
            ->setParameter('val', $healthContainer)
            ->orderBy('bt.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
