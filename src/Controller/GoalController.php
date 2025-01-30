<?php

namespace App\Controller;

use App\Entity\Goal;
use App\Form\GoalType;
use App\Repository\GoalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/objectif')]
final class GoalController extends AbstractController
{
    #[Route('s', name: 'goal_index', methods: ['GET'])]
    public function index(GoalRepository $goalRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $goals = $goalRepository->findBy([
            'user' => $this->getUser()
        ]);

        return $this->render('goal/index.html.twig', [
            'goals' => $goals,
        ]);
    }

    #[Route('/nouveau', name: 'goal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $goal = new Goal();
        $goal->setCreatedAt(new \DateTimeImmutable());
        $goal->setIsAchieved(false);
        $goal->setUser($this->getUser());

        $form = $this->createForm(GoalType::class, $goal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($goal);
            $entityManager->flush();

            $this->addFlash('success', 'Objectif Créé !');

            return $this->redirectToRoute('goal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('goal/new.html.twig', [
            'goal' => $goal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/atteint', name: 'goal_set_achieved', methods: ['POST'])]
    public function setAchieved(int $id, GoalRepository $goalRepository, EntityManagerInterface $entityManager): Response
    {
        $goal = $goalRepository->find($id);

        if ($goal) {
            $goal->setIsAchieved(!$goal->isAchieved());  // Inverse l'état actuel
            $entityManager->flush();
        }

        $this->addFlash('success', 'Objectif atteint ! Félicitations');

        return $this->redirectToRoute('goal_index');
    }

    #[Route('/voir/{id}', name: 'goal_show', methods: ['GET'])]
    public function show(Goal $goal): Response
    {
        return $this->render('goal/show.html.twig', [
            'goal' => $goal,
        ]);
    }

    #[Route('/{id}/modifier', name: 'goal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Goal $goal, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(GoalType::class, $goal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Objectif modifié !');

            return $this->redirectToRoute('goal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('goal/edit.html.twig', [
            'goal' => $goal,
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'goal_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Goal $goal, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }
        
        $entityManager->remove($goal);
        $entityManager->flush();

        $this->addFlash('success', 'Objectif supprimé !');

        return $this->redirectToRoute('goal_index', [], Response::HTTP_SEE_OTHER);
    }
}
