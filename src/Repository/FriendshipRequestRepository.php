<?php

namespace App\Repository;

use App\Entity\FriendshipRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FriendshipRequest>
 *
 * @method FriendshipRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method FriendshipRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method FriendshipRequest[]    findAll()
 * @method FriendshipRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FriendshipRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FriendshipRequest::class);
    }

    /**
     * @return FriendshipRequest[] Returns an array of FriendshipRequest objects
     */
    public function findByUser($user): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.sender = :val OR f.recipient = :val')
            ->setParameter('val', $user)
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return FriendshipRequest[] Returns an array of FriendshipRequest objects
     */
    public function findInvitations($user): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.recipient = :val')
            ->setParameter('val', $user)
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Bool
     */
    public function isRequested($user1, $user2): bool
    {
        $result = $this->createQueryBuilder('r')
            ->andWhere('(r.sender = :user1 AND r.recipient = :user2)')
            ->orWhere('(r.sender = :user2 AND r.recipient = :user1)')
            ->setParameter('user1', $user1)
            ->setParameter('user2', $user2)
            ->getQuery()
            ->getResult();

        return !empty($result);
    }

    //    public function findOneBySomeField($value): ?FriendshipRequest
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
