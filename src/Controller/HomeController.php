<?php

namespace App\Controller;

use App\Repository\FriendshipRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function __construct(private FriendshipRequestRepository $friendshipRequestRepository)
    {
        
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /* public function navbar()
    {
        $user = $this->getUser();
        $invitations = $this->friendshipRequestRepository->findInvitations($user);

        return $this->render('nav/nav.html.twig', [
            'invitations' => $invitations
        ]);
    } */
}
