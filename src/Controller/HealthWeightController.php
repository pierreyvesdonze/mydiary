<?php

namespace App\Controller;

use App\Entity\Weight;
use App\Form\HealthWeightType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/sante')]
class HealthWeightController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {}

    #[Route('/poids/nouveau', name: 'health_weight_new')]
    public function newWeight(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $weight = new Weight();
        $form = $this->createForm(HealthWeightType::class, $weight);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $weight->setHealthContainer($user->getHealthContainer());
            
            $this->em->persist($weight);
            $this->em->flush();

            $this->addFlash('success', 'Nouveau poids enregistré.');

            return $this->redirectToRoute('health_index');
        }

        return $this->render('health/weight.new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/poids/supprimer/{id}', name: 'health_weight_delete')]
    public function deleteWeight(Weight $weight): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        if ($weight->getHealthContainer()->getUser() !== $user) {
            $this->addFlash('error', 'Je ne sais pas ce que vous essayez de faire, mais ça ne marche pas...');

            return $this->redirectToRoute('home');
        }

        $this->em->remove($weight);
        $this->em->flush();

        $this->addFlash('success', 'Poids supprimé');

        return $this->redirectToRoute('health_index');
    }
}