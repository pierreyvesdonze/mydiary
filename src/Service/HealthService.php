<?php

namespace App\Service;

use App\Entity\Weight;
use Doctrine\ORM\EntityManagerInterface;

class HealthService
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    // Détermine si le poids actuel est en hausse ou en baisse par rapport au précédent
/*     public function isHigher($weights) {

        $isHigher = usort($weights, function (Weight $a, Weight $b) {
            return $b->getDate() <=> $a->getDate();
        });

        if (count($weights) > 1) {
            $latestWeight   = $weights[0]->getWeight();
            $previousWeight = $weights[1]->getWeight();
            $isHigher       = $latestWeight > $previousWeight;
        } else {
            $latestWeight   = null;
            $previousWeight = null;
            $isHigher       = null;
        }
        return $isHigher;
    } */

    
    // Formate la taille pour afficher par ex. 1m80
    public function formatHeight($height)
    {
        $integerPart = floor($height / 100);
        $decimalPart = $height % 100;

        return $integerPart . 'm' . $decimalPart;
    }

    // Calcul l'IMC
    public function getImc($height, $weight)
    {
        $heightValue = (int)$height->getValue();
        $weightValue = (int)$weight->getWeight();
        if ($heightValue > 99) {
            $formatedHeight = $heightValue / 100;
        } else {
            $formatedHeight = $heightValue / 10;
        }

        $imc = number_format($weightValue / ($formatedHeight * $formatedHeight), 1);

        // Vérification de la catégorie IMC
        if ($imc < 18.5) {
            $imcCategory = 'Insuffisance pondérale';
        } elseif ($imc >= 18.5 && $imc < 25) {
            $imcCategory = 'Poids normal';
        } elseif ($imc >= 25 && $imc < 30) {
            $imcCategory = 'Surpoids';
        } else {
            $imcCategory = 'Obésité';
        }

        return [$imc, $imcCategory];
    }
}
