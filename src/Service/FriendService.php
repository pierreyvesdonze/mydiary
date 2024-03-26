<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\FriendshipRepository;
use App\Repository\FriendshipRequestRepository;
use Doctrine\ORM\EntityManagerInterface;

class FriendService
{
    private $entityManager;
    private $friendshipRequestRepository;
    private $friendshipRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        FriendshipRequestRepository $friendshipRequestRepository,
        FriendshipRepository $friendshipRepository,
        )
    {
        $this->entityManager               = $entityManager;
        $this->friendshipRequestRepository = $friendshipRequestRepository;
        $this->friendshipRepository        = $friendshipRepository;
    }

    public function isFriendshipRequested(
        User $user,
        User $recipient,
    ): bool {
        
        $isRequested = $this->friendshipRequestRepository->isRequested($user, $recipient);

        if ($isRequested) {
            return $isRequested;
        }

        return false;
    }

    public function isFriend(
        $user1,
        $user2
    ): bool {
        $isFriend = $this->friendshipRepository->hasFriendship($user1,$user2);

        if ($isFriend) {
            return $isFriend;
        }

        return false;
    }
}
