<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class MoodService
{
    public function getMoodAverage($moods)
    {
        // Initialiser un tableau pour compter le nombre de chaque dayMood
        $moodCounts = [
            'Joyeux' => 0,
            'Neutre' => 0,
            'Fatigué' => 0,
            'Anxieux' => 0,
            'Déprimé' => 0
        ];

        // Parcourir les moods et compter le nombre de chaque dayMood
        foreach ($moods as $mood) {
            $dayMood = $mood->getDayMood();
            if (array_key_exists($dayMood, $moodCounts)) {
                $moodCounts[$dayMood]++;
            }
        }

        // Trouver le mood avec le nombre le plus élevé
        $mostCommonMood = '';
        $maxCount = 0;
        foreach ($moodCounts as $dayMood => $count) {
            if ($count > $maxCount) {
                $mostCommonMood = $dayMood;
                $maxCount = $count;
            }
        }

        // $mostCommonMood contient maintenant le mood le plus courant
        return $mostCommonMood;
    }
}
