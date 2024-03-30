<?php

namespace App\Controller;

use App\Entity\RoutineTask;
use App\Form\RoutineTaskType;
use App\Repository\RoutineRepository;
use App\Repository\RoutineTaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/routines/tache')]
class RoutineTaskController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/nouvelle/{routine}', name: 'routine_task_new', methods: ['GET', 'POST'])]
    public function new(
        $routine,
        Request $request,
        RoutineRepository $routineRepository

    ): Response {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('routine_index');
        }

        $routineTask      = new RoutineTask();
        $routine          = $routineRepository->findOneBy(['id' => $routine]);
        $routineContainer = $routine->getRoutineContainer();

        if (count($routine->getRoutineTasks()) < 1 ) {
            $isFirstRoutineTask = true;
        } else {
            $isFirstRoutineTask = false;
        }

        $form = $this->createForm(RoutineTaskType::class, $routineTask, [
            'attr' => ['class' => 'custom-form']
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $routineTask->setRoutine($routine);
            $this->em->persist($routineTask);
            $this->em->flush();

            $this->addFlash('success', 'Nouvelle tâche créée !');

            return $this->redirectToRoute('routine_show', [
                'id' => $routine->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('routine_task/new.html.twig', [
            'routine'            => $routine,
            'routine_task'       => $routineTask,
            'form'               => $form,
            'isFirstRoutineTask' => $isFirstRoutineTask
        ]);
    }

    #[Route('/modifier/{id}', name: 'routine_task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RoutineTask $routineTask): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $form = $this->createForm(RoutineTaskType::class, $routineTask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'Tâche modifiée');

            return $this->redirectToRoute('routine_show', [
                'id' => $routineTask->getRoutine()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('routine_task/edit.html.twig', [
            'routineTask' => $routineTask,
            'form'        => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'routine_task_delete')]
    public function delete(RoutineTask $routineTask): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('routine_index');
        }

        $this->em->remove($routineTask);
        $this->em->flush();

        $this->addFlash('success', 'Tâche supprimée !');

        return $this->redirectToRoute('routine_show', [
            'id' => $routineTask->getRoutine()->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
