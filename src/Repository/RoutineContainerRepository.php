<?php

namespace App\Repository;

use App\Entity\RoutineContainer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RoutineContainer>
 *
 * @method RoutineContainer|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoutineContainer|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoutineContainer[]    findAll()
 * @method RoutineContainer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoutineContainerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoutineContainer::class);
    }
}
