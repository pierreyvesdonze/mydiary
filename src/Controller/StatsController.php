<?php

// src/Controller/StatsController.php

namespace App\Controller;

use App\Repository\MoodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{
    #[Route('/stats', name: 'stats')]
    public function stats(MoodRepository $moodRepository): Response
    {
        // Récupérer les humeurs de l'utilisateur triées par date
        $moods = $moodRepository->findBy(['user' => $this->getUser()], ['date' => 'ASC']);

        // Initialisation des tableaux
        $labels = [];
        $moodData = [];

        // Remplir les tableaux avec les données nécessaires
        foreach ($moods as $mood) {
            $labels[] = $mood->getDate()->format('Y-m-d');  // Format ISO des dates
            $moodData[] = $this->convertMoodToNumber($mood->getDayMood());
        }

        return $this->render('stats.html.twig', [
            'labels' => json_encode($labels),
            'moodData' => json_encode($moodData),
        ]);
    }

    // Convertit l'humeur en valeur numérique pour le graphique
    private function convertMoodToNumber(string $mood): int
    {
        return match ($mood) {
            'Déprimé' => 1,
            'Fatigué' => 2,
            'Neutre' => 3,
            'Joyeux' => 4,
            default => 0
        };
    }
}
