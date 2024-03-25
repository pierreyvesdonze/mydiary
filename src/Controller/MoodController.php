<?php

namespace App\Controller;

use App\Entity\Mood;
use App\Form\MoodType;
use App\Repository\MoodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/humeur')]
class MoodController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }
    #[Route('/', name: 'mood_index', methods: ['GET'])]
    public function index(MoodRepository $moodRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $moodContainer = $user->getMoodContainer();
        $moods = $moodRepository->findByMoodContainer($moodContainer);

        return $this->render('mood/index.html.twig', [
            'moods' => $moods,
        ]);
    }

    #[Route('/nouveau', name: 'mood_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $mood = new Mood();
        $form = $this->createForm(MoodType::class, $mood);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mood->setMoodContainer($user->getMoodContainer());

            $this->em->persist($mood);
            $this->em->flush();

            $this->addFlash('success', 'Humeur créée');

            return $this->redirectToRoute('mood_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mood/new.html.twig', [
            'mood' => $mood,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'mood_show', methods: ['GET'])]
    public function show(Mood $mood): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        return $this->render('mood/show.html.twig', [
            'mood' => $mood,
        ]);
    }

    #[Route('/modifier/{id}/', name: 'mood_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mood $mood): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $form = $this->createForm(MoodType::class, $mood);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('mood_index', [], Response::HTTP_SEE_OTHER);
        }

        $this->addFlash('success', 'Humeur modifiée');

        return $this->render('mood/edit.html.twig', [
            'mood' => $mood,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'mood_delete', methods: ['POST'])]
    public function delete(Mood $mood): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $this->em->remove($mood);
        $this->em->flush();

        $this->addFlash('success', 'Humeur supprimée');

        return $this->redirectToRoute('mood_index', [], Response::HTTP_SEE_OTHER);
    }
}
