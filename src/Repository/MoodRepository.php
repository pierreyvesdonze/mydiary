<?php

namespace App\Repository;

use App\Entity\Mood;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mood>
 *
 * @method Mood|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mood|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mood[]    findAll()
 * @method Mood[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mood::class);
    }

    /**
     * @return Mood[] Returns an array of Mood objects
     */
    public function findByMoodContainer($moodContainer): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.moodContainer = :val')
            ->setParameter('val', $moodContainer)
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
