<?php

namespace App\Repository;

use App\Entity\MoodContainer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MoodContainer>
 *
 * @method MoodContainer|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoodContainer|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoodContainer[]    findAll()
 * @method MoodContainer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoodContainerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MoodContainer::class);
    }

    //    /**
    //     * @return MoodContainer[] Returns an array of MoodContainer objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MoodContainer
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
