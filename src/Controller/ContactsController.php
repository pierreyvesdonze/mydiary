<?php

namespace App\Controller;

use App\Entity\Friendship;
use App\Entity\FriendshipRequest;
use App\Repository\FriendshipRepository;
use App\Repository\FriendshipRequestRepository;
use App\Repository\UserRepository;
use App\Service\FriendService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/contacts')]
class ContactsController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {}

    #[Route('/', name: 'contacts')]
    public function index(
        UserRepository $userRepository,
        FriendshipRepository $friendshipRepository,
        FriendService $friendService,
    ): Response {

        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $contacts          = $friendshipRepository->findFriendships($user);
        $friendRequests    = $userRepository->findUserRequests($user);
        $unrelatedContacts = $userRepository->findUnrelatedContacts($user);

        $isFriendshipRequested = [];
        $isFriend              = [];

        foreach ($unrelatedContacts as $contact) {       
            $isRequested = $friendService->isFriendshipRequested($user, $contact);
            $isFriendshipRequested[$contact->getId()] = $isRequested;

            $isFriendship = $friendService->isFriend($user, $contact);
            $isFriend[$contact->getId()] = $isFriendship;
        }

        return $this->render('contacts/index.html.twig', [
            'friendRequests'        => $friendRequests,
            'unrelatedContacts'     => $unrelatedContacts,
            'contacts'              => $contacts,
            'isFriendshipRequested' => $isFriendshipRequested,
            'isFriend'              => $isFriend,
        ]);
    }

    #[Route('/requete/contact', name: 'friendship_request', methods: ['GET'])]
    public function setFriendshipRequest(
        Request $request,
        UserRepository $userRepository,
    ) {
        $user = $this->getUser();
        
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $userTargetId = $request->query->get('userTargetId');
        $userTarget   = $userRepository->findOneBy([
            'id' => $userTargetId
        ]);

        if ($userTarget) {
            $friendshipRequest = new FriendshipRequest();
            $friendshipRequest->setSender($user);
            $friendshipRequest->setRecipient($userTarget);

            $this->em->persist($friendshipRequest);
            $this->em->flush();

            $this->addFlash('success', 'Demande de connexion envoyée !');
        } else {
            $this->addFlash('error', 'Votre demande ne peut aboutir !');
        }

        return $this->redirectToRoute('contacts');
    }

    #[Route('/nouveau', name: 'create_friendship', methods: ['GET'])]
    public function createFriendship(
        Request $request,
        UserRepository $userRepository,
    )
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $senderId = $request->get('sender');

        $user2 = $userRepository->findOneBy([
            'id' => $senderId
        ]);
        
        $newFriendship = new Friendship();
        $newFriendship->setUser1($user);
        $newFriendship->setUser2($user2);

        $this->em->persist($newFriendship);
        $this->em->flush();

        $this->addFlash('success', 'Invitation approuvée !');

        return $this->redirectToRoute('delete_friendship_request', [
            'user2' => $user2->getId(),
        ]);

    }
    
    #[Route('/requete/supprimer/{user2}', name: 'delete_friendship_request')]
    public function deleteFriendshipRequest(
        $user2,
        FriendshipRequestRepository $friendshipRequestRepository,
        )
    {
        $requestToDelete = $friendshipRequestRepository->findOneByUser($user2);
        $this->em->remove($requestToDelete[0]);
        $this->em->flush();
        
        return $this->redirectToRoute('contacts');
    }

    #[Route('/contact/supprimer/{user2}', name: 'delete_friendship')]
    public function deleteFriendship(
        $user2,
        FriendshipRepository $friendshipRepository
    )
    {
        $friendshipToDelete = $friendshipRepository->findOneByUser($user2);

        $this->em->remove($friendshipToDelete[0]);
        $this->em->flush();
        
        $this->addFlash('success', 'Le contact a bien été supprimé !');

        return $this->redirectToRoute('contacts');
    }
}
