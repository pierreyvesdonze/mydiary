<?php

namespace App\Controller;

use App\Entity\BloodType;
use App\Entity\Height;
use App\Form\HealthBloodTypeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sante')]
class HealthBloodController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {}

    #[Route('/groupe/sanguin/creer', name: 'health_blood_type_new')]
    public function newBloodType(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $bloodType = new BloodType();
        $form = $this->createForm(HealthBloodTypeType::class, $bloodType);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $bloodType->setHealthContainer($user->getHealthContainer());
            
            $this->em->persist($bloodType);
            $this->em->flush();

            $this->addFlash('success', 'Groupe sanguin enregistré.');

            return $this->redirectToRoute('health_index');
        }

        return $this->render('health/bloodtype.new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/groupe/sanguin/modifier{id}', name: 'health_blood_type_edit')]
    public function editBloodType(
        BloodType $bloodType,
        Request $request
        ): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $form = $this->createForm(HealthBloodTypeType::class, $bloodType);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->em->flush();
            $this->addFlash('success', 'Groupe sanguin modifié.');

            return $this->redirectToRoute('health_index');
        }

        return $this->render('health/bloodtype.new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/groupe/sanguin/supprimer/{id}', name: 'health_blood_type_delete')]
    public function deleteBloodType(BloodType $bloodType): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $this->em->remove($bloodType);
        $this->em->flush();

        $this->addFlash('success', 'Groupe sanguin supprimé');

        return $this->redirectToRoute('health_index');
    }
}