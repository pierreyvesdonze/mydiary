<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class HealthService
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    // Formate la taille pour afficher par ex. 1m80
    public function formatHeight($height)
    {
        $integerPart = floor($height / 100);
        $decimalPart = $height % 100;

        return $integerPart . 'm' . $decimalPart;
    }
}
