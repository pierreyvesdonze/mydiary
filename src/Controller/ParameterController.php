<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\EnvironnementService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ParameterController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    #[Route('/parametres', name: 'parameters')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $moodVisibility    = $user->getMoodContainer()->isVisibility();
        $bookVisibility    = $user->getBook()->isVisibility();
        $datesVisibility   = $user->getDatesContainer()->isVisibility();
        $healthVisibility  = $user->getHealthContainer()->isVisibility();
        $routineVisibility = $user->getRoutineContainer()->isVisibility();

        return $this->render('parameter/index.html.twig', [
            'bookVisibility'    => $bookVisibility,
            'datesVisibility'   => $datesVisibility,
            'moodVisibility'    => $moodVisibility,
            'healthVisibility'  => $healthVisibility,
            'routineVisibility' => $routineVisibility,
            'env'               => $_ENV['APP_ENV'],
        ]);
    }

    #[Route('/visibilite', name: 'change_visibility', options: ['expose' => true])]
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
        } elseif ($requestData == 'mood') {
            $moodContainer = $user->getMoodContainer();
            $moodContainer->isVisibility(true) ? $moodContainer->setVisibility(false) : $moodContainer->setVisibility(true);
        } elseif ($requestData == 'health') {
            $healthContainer = $user->getHealthContainer();
            $healthContainer->isVisibility(true) ? $healthContainer->setVisibility(false) : $healthContainer->setVisibility(true);
        } elseif ($requestData == 'routine') {
            $routineContainer = $user->getRoutineContainer();
            $routineContainer->isVisibility(true) ? $routineContainer->setVisibility(false) : $routineContainer->setVisibility(true);
        }

        $this->em->flush();

        return new JsonResponse($requestData);
    }

    #[Route('/changer/pseudo/utilisateur', name: 'change_user_pseudo', options: ['expose' => true])]
    public function changeUserPseudo(
        Request $request,
        UserRepository $userRepository,
    ): JsonResponse {
        
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $requestData = $request->getContent();

        $userExist = $userRepository->findOneBy([
            'pseudo' => $requestData
        ]);

        if($userExist) {
            return new JsonResponse(true);
        } 

        $user->setPseudo($requestData);
        $this->em->flush();

        return new JsonResponse(false);
    }

    #[Route('/changer/mantra/utilisateur', name: 'change_user_mantra', options: ['expose' => true])]
    public function changeUserMantra(
        Request $request,
        UserRepository $userRepository,
    ): JsonResponse {
        
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $requestData = $requestData = $request->get('mantra');

        $userExist = $userRepository->findOneBy([
            'pseudo' => $requestData
        ]);

        if($userExist) {
            return new JsonResponse(true);
        } 

        $user->setMantra($requestData);
        $this->em->flush();

        return new JsonResponse(false);
    }
}
