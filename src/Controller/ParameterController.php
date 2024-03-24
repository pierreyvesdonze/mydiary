<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ParameterController extends AbstractController
{

    public function __construct(private EntityManagerInterface $em)
    {}

    #[Route('/parametres', name: 'parameters')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $bookVisibility  = $user->getBook()->isVisibility();
        $datesVisibility = $user->getDatesContainer()->isVisibility();

        return $this->render('parameter/index.html.twig', [
            'bookVisibility' => $bookVisibility,
            'datesVisibility' => $datesVisibility,
        ]);
    }

    #[Route('/visibilite', name: 'change_visibility', options: ['expose' => true] )]
    public function changeVisibility(Request $request): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $requestData = $request->getContent();

        if ($requestData === 'date') {
            $datesContainer = $user->getDatesContainer();
            $datesContainer->isVisibility(true) ? $datesContainer->setVisibility(false) : $datesContainer->setVisibility(true);
        } elseif ($requestData === 'book') {
            $book = $user->getBook();
            $book->isVisibility(true) ? $book->setVisibility(false) : $book->setVisibility(true);
        }

        $this->em->flush();

        return new JsonResponse($requestData);
    }
}
