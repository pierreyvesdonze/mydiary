<?php

namespace App\Controller;

use App\Entity\Height;
use App\Form\HealthHeightType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sante')]
class HealthHeightController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {}

    #[Route('/taille/nouvelle', name: 'health_height_new')]
    public function newWeight(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $height = new Height();
        $form = $this->createForm(HealthHeightType::class, $height);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $height->setHealthContainer($user->getHealthContainer());
            
            $this->em->persist($height);
            $this->em->flush();

            $this->addFlash('success', 'Taille enregistrée.');

            return $this->redirectToRoute('health_index');
        }

        return $this->render('health/height.new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/taille/supprimer/{id}', name: 'health_height_delete')]
    public function deleteHeight(Height $height): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $this->em->remove($height);
        $this->em->flush();

        $this->addFlash('success', 'Taille supprimée');

        return $this->redirectToRoute('health_index');
    }
}