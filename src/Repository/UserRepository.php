<?php

namespace App\Repository;

use App\Entity\FriendshipRequest;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findContacts($userId): array
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.friendships', 'f1', 'WITH', 'f1.user1 = :userId')
            ->andWhere('u.id != :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }


    /**
     * @return User[] Returns an array of User objects
     */
    public function findUserRequests($recipientId): array
    {
        return $this->createQueryBuilder('u')
            ->leftJoin(FriendshipRequest::class, 'fr', 'WITH', 'fr.sender = u.id')
            ->andWhere('fr.recipient = :recipientId')
            ->setParameter('recipientId', $recipientId)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findUnrelatedContacts($userId): array
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.friendships', 'f')
            ->andWhere('u.id != :userId')
            ->andWhere(':userId NOT MEMBER OF u.friendships')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }
}
