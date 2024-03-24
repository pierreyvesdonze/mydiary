<?php

namespace App\Repository;

use App\Entity\Friendship;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Friendship>
 *
 * @method Friendship|null find($id, $lockMode = null, $lockVersion = null)
 * @method Friendship|null findOneBy(array $criteria, array $orderBy = null)
 * @method Friendship[]    findAll()
 * @method Friendship[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FriendshipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Friendship::class);
    }

    /**
     * @return Friendship[] Returns an array of Friendship objects
     */
    public function findFriendships($user): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('(f.user1 = :val OR f.user2 = :val) AND (f.user1 != :val OR f.user2 != :val)')
            ->setParameter('val', $user)
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function hasFriendship($user1, $user2): bool
    {
        $result = $this->createQueryBuilder('f')
            ->andWhere('(f.user1 = :user1 AND f.user2 = :user2)')
            ->orWhere('(f.user1 = :user2 AND f.user2 = :user1)')
            ->setParameter('user1', $user1)
            ->setParameter('user2', $user2)
            ->getQuery()
            ->getResult();

        return !empty($result);
    }

    /**
     * @return Friendship
     */
    public function findOneByUsers($user, $friend): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('(f.user1 = :user AND f.user2 = :friend) OR (f.user1 = :friend AND f.user2 = :user)')
            ->setParameter('user', $user)
            ->setParameter('friend', $friend)
            ->getQuery()
            ->getResult();
    }
}
