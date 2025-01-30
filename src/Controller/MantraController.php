<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MantraController extends AbstractController
{
    #[Route('/mantra', name: 'app_mantra')]
    public function index(): Response
    {
        return $this->render('mantra/index.html.twig', [
            'controller_name' => 'MantraController',
        ]);
    }
}
