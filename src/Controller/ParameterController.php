<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ParameterController extends AbstractController
{
    #[Route('/parametres', name: 'parameters')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $bookVisibility = $user->getBook()->isVisibility();

        return $this->render('parameter/index.html.twig', [
            'controller_name' => 'ParameterController',
        ]);
    }
}
