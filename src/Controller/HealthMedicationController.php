<?php

namespace App\Controller;

use App\Entity\Medication;
use App\Form\HealthMedicationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/sante')]
class HealthMedicationController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {}

    #[Route('/traitement/nouveau', name: 'health_medication_new')]
    public function newMedication(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $medication = new Medication();
        $form = $this->createForm(HealthMedicationType::class, $medication);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $medication->setHealthContainer($user->getHealthContainer());
            
            $this->em->persist($medication);
            $this->em->flush();

            $this->addFlash('success', 'Nouveau traitement enregistré.');

            return $this->redirectToRoute('health_index');
        }

        return $this->render('health/medication.new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/traitement/supprimer/{id}', name: 'health_medication_delete')]
    public function deleteMedication(Medication $medication): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        if ($medication->getHealthContainer()->getUser() !== $user) {
            $this->addFlash('error', 'Je ne sais pas ce que vous essayez de faire, mais ça ne marche pas...');

            return $this->redirectToRoute('home');
        }

        $this->em->remove($medication);
        $this->em->flush();

        $this->addFlash('success', 'Traitement supprimé');

        return $this->redirectToRoute('health_index');
    }
}