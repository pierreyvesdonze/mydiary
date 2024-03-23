<?php

namespace App\Controller;

use App\Entity\Date;
use App\Form\DateType;
use App\Repository\DateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/date')]
class DateController extends AbstractController
{
    #[Route('/', name: 'date_index', methods: ['GET'])]
    #[Route('/index/guest', name: 'date_index_guest', methods: ['GET'])]
    public function index(
        DateRepository $dateRepository,
        Request $request
        ): Response
    {
        $dates = $dateRepository->findBy(['user' => $this->getUser()]);

        // Trier les dates par année
        usort($dates, function ($a, $b) {
            return $a->getDate()->format('Y') - $b->getDate()->format('Y');
        });

        // Récupérer le nom de la route pour orienter la vue

        $routeName = $request->get('_route');
        if ($routeName === 'date_index') {
            return $this->render('date/index.html.twig', [
                'dates' => $dates,
            ]);
        } else {
            return $this->render('date/index.guest.html.twig', [
                'dates' => $dates,
            ]);
        }
    }

    #[Route('/new', name: 'date_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $date = new Date();
        $user = $this->getUser();
        $form = $this->createForm(DateType::class, $date);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date->setUser($user);
            $date->setVisibility(0);
 
            $entityManager->persist($date);
            $entityManager->flush();

            $this->addFlash('success', 'Date créée !');

            return $this->redirectToRoute('date_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('date/new.html.twig', [
            'date' => $date,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'date_show', methods: ['GET'])]
    public function show(Date $date): Response
    {
        return $this->render('date/show.html.twig', [
            'date' => $date,
        ]);
    }

    #[Route('/{id}/edit', name: 'date_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Date $date, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DateType::class, $date);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('date_index', [], Response::HTTP_SEE_OTHER);
        }

        $this->addFlash('success', 'Date modifiée !');

        return $this->render('date/edit.html.twig', [
            'date' => $date,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'date_delete', methods: ['POST'])]
    public function delete(Request $request, Date $date, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($date);
        $entityManager->flush();

        $this->addFlash('success', 'Date supprimée !');

        return $this->redirectToRoute('date_index', [], Response::HTTP_SEE_OTHER);
    }
}
