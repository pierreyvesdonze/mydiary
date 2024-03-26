<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\HealthContainer;
use App\Entity\Weight;
use App\Form\HealthWeightType;
use App\Repository\HealthContainerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/sante')]
class HealthController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/index', name: 'health_index')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $healthContainer = $user->getHealthContainer();

        $cares    = $healthContainer->getCares();
        $vaccines = $healthContainer->getVaccines();
        $height   = $healthContainer->getHeight();

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
        }

        return $this->render('health/index.html.twig', [
            'cares'    => $cares,
            'vaccines' => $vaccines,
            'height'   => $height,
            'weights'  => $weights,
            'isHigher' => $isHigher,
        ]);
    }
}
