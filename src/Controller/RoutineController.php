<?php

namespace App\Controller;

use App\Entity\Mood;
use App\Entity\Routine;
use App\Form\RoutineType;
use App\Repository\RoutineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/routines')]
class RoutineController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }
    #[Route('/', name: 'routine_index', methods: ['GET'])]
    public function index(RoutineRepository $routineRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $routineContainer = $user->getRoutineContainer();
        $routines         = $routineRepository->findByRoutineContainer($routineContainer);

        return $this->render('routine/index.html.twig', [
            'routines' => $routines,
        ]);
    }

    #[Route('/nouvelle', name: 'routine_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $newRoutine = new Routine();
        $form = $this->createForm(RoutineType::class, $newRoutine, [
            'attr' => ['class' => 'custom-form']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newRoutine->setRoutineContainer($user->getRoutineContainer());

            foreach ($newRoutine->getRoutineTasks() as $routineTask) {
                $routineTask->setRoutine($newRoutine);
                $this->em->persist($routineTask);
            }

            $this->em->persist($newRoutine);
            $this->em->flush();

            $this->addFlash('success', 'Routine créée');

            return $this->redirectToRoute('routine_task_new', [
                'routine' => $newRoutine->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('routine/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/voir/{id}', name: 'routine_show', methods: ['GET'])]
    public function show(
        Routine $routine
    ): Response {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $routineTasks = $routine->getRoutineTasks()->toArray();
        usort($routineTasks, function($a, $b) {
            return $a->getStartAt() <=> $b->getStartAt();
        });

        return $this->render('routine/show.html.twig', [
            'routine'       => $routine,
            'routineTasks' => $routineTasks,
        ]);
    }

    #[Route('/modifier/{id}/', name: 'routine_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Routine $routine): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $form = $this->createForm(RoutineType::class, $routine, [
            'attr' => ['class' => 'custom-form']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'Routine modifiée');
            return $this->redirectToRoute('routine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('routine/edit.html.twig', [
            'routine' => $routine,
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'routine_delete')]
    public function delete(Routine $routine): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $this->em->remove($routine);
        $this->em->flush();

        $this->addFlash('success', 'Routine supprimée');

        return $this->redirectToRoute('routine_index', [], Response::HTTP_SEE_OTHER);
    }
}
