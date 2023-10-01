<?php

namespace App\Repository;

use App\Entity\BookContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookContent>
 *
 * @method BookContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookContent[]    findAll()
 * @method BookContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookContent::class);
    }

//    /**
//     * @return BookContent[] Returns an array of BookContent objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BookContent
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
