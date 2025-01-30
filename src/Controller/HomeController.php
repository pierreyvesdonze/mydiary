<?php

namespace App\Controller;

use App\Entity\MoodContainer;
use App\Repository\FriendshipRequestRepository;
use App\Repository\MoodRepository;
use App\Service\MoodService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function __construct(private FriendshipRequestRepository $friendshipRequestRepository) {}

    #[Route('/', name: 'home')]
    public function index(
        MoodRepository $moodRepository,
        MoodService $moodService
    ): Response {
        $user = $this->getUser();

        if ($user) {
            $moodContainer = $user->getMoodContainer();
            $moods = $moodRepository->findByMoodContainerLast30Entries($moodContainer);

            $moodAverage = $moodService->getMoodAverage($moods);

            // Calcul des données pour le graphique
            $labels    = [];
            $moodData  = [];

            foreach ($moods as $mood) {
                $labels[] = $mood->getDate()->format('Y-m-d'); // formatage de la date
                $moodData[] = $mood->getDayMood(); // ou la valeur de l'humeur
            }

            return $this->render('home/user.index.html.twig', [
                'moodAverage' => $moodAverage,
                'labels'       => json_encode($labels),
                'moodData'     => json_encode($moodData)
            ]);
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
