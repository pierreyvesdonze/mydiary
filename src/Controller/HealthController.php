<?php

namespace App\Controller;

use App\Entity\Weight;
use App\Service\HealthService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/sante')]
class HealthController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/index', name: 'health_index')]
    public function index(HealthService $healthService): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        /**
         * @var HealthContainer|null $healthContainer
         */
        $healthContainer = $user->getHealthContainer();

        $cares     = $healthContainer->getCares();
        $height    = $healthContainer->getHeight();
        $bloodType = $healthContainer->getBloodType();
        $vaccines  = $healthContainer->getVaccines();

        // Effectue un tri sur la collection pour déterminer si le poids actuel est en hausse
        $weights  = $healthContainer->getWeights()->toArray();
        if ($weights) {
            usort($weights, function (Weight $a, Weight $b) {
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
        } else {
            $isHigher = null;
        }

        // Initialisation des variables pour calcul de l'IMC
        $imc         = null;
        $imcCategory = null;

        // Formate la taille
        if ($height) {
            $formatedHeight = $healthService->formatHeight($height->getValue());
        } else {
            $formatedHeight = null;
        }

        if ($height && $weights) {
            $imcArray    = $healthService->getImc($height, $weights[0]);
            $imc         = $imcArray[0];
            $imcCategory = $imcArray[1];
        }

        return $this->render('health/index.html.twig', [
            'cares'          => $cares,
            'vaccines'       => $vaccines,
            'height'         => $height,
            'weights'        => $weights,
            'isHigher'       => $isHigher,
            'height'         => $height,
            'formatedHeight' => $formatedHeight,
            'imc'            => $imc,
            'imcCategory'    => $imcCategory,
            'bloodType'      => $bloodType,
        ]);
    }
}
