<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class QuoteService
{
    public function isExist($quotes, $userQuote) {

        // Normalisation des citations
        $userQuote = preg_replace('/\W/', '', strtolower($userQuote));

        // Seuil de similarité minimum
        $similarityTreshold = 0.7; // Seuil de 70%

        // Vérification de la similarité avec chaque citation existante
        foreach ($quotes as $existingQuote) {
            // Normalisation de la citation existante
            $existingQuote = preg_replace('/\W/', '', strtolower($existingQuote->getText()));

            // Calcul de la distance de Levenshtein
            $distance = levenshtein($userQuote, $existingQuote);

            // Calcul de la similarité normalisée
            $maxLength = max(strlen($userQuote), strlen($existingQuote));
            $similarity = 1 - ($distance / $maxLength);

            // Comparaison avec le seuil de similarité
            if ($similarity >= $similarityTreshold) {
              
                return true;
            }
        }

        return false;
    }
}
