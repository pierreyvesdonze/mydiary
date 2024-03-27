<?php

namespace App\Controller;

use App\Entity\BloodType;
use App\Entity\Height;
use App\Entity\Vaccine;
use App\Form\HealthBloodTypeType;
use App\Form\HealthVaccineType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sante')]
class HealthVaccineController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {}

    #[Route('/vaccin/creer', name: 'health_vaccine_new')]
    public function newVaccine(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $vaccine = new Vaccine();
        $form = $this->createForm(HealthVaccineType::class, $vaccine);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $vaccine->setHealthContainer($user->getHealthContainer());
            
            $this->em->persist($vaccine);
            $this->em->flush();

            $this->addFlash('success', 'Nouveau vaccin enregistré.');

            return $this->redirectToRoute('health_index');
        }

        return $this->render('health/vaccine.new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/vaccine/supprimer/{id}', name: 'health_vaccine_delete')]
    public function deleteVaccine(Vaccine $vaccine): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $this->em->remove($vaccine);
        $this->em->flush();

        $this->addFlash('success', 'Vaccin supprimé');

        return $this->redirectToRoute('health_index');
    }
}