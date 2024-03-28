<?php

namespace App\Controller;

use App\Entity\HealthCondition;
use App\Form\HealthConditionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sante')]
class HealthConditionController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {}

    #[Route('/particularite/creer', name: 'health_condition_new')]
    public function newVaccine(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $healthCondition = new HealthCondition();
        $form = $this->createForm(HealthConditionType::class, $healthCondition);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $healthCondition->setHealthContainer($user->getHealthContainer());
            
            $this->em->persist($healthCondition);
            $this->em->flush();

            $this->addFlash('success', 'Maladie/Handicap enregistré(e).');

            return $this->redirectToRoute('health_index');
        }

        return $this->render('health/healthCondition.new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/particularite/supprimer/{id}', name: 'health_condition_delete')]
    public function deleteVaccine(HealthCondition $healthCondition): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $this->em->remove($healthCondition);
        $this->em->flush();

        $this->addFlash('success', 'Maladie/Handicap supprimé(e).');

        return $this->redirectToRoute('health_index');
    }
}