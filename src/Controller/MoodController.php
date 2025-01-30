<?php

namespace App\Controller;

use App\Entity\Mood;
use App\Form\MoodType;
use App\Repository\MoodRepository;
use App\Service\MoodService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/humeur')]
class MoodController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em) {}

    #[Route('/', name: 'mood_index', methods: ['GET'])]
    public function index(
        MoodRepository $moodRepository,
        MoodService $moodService,
        PaginatorInterface $paginator,
        Request $request,
    ): Response {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $moodContainer = $user->getMoodContainer();
        
        // Récupère les 30 dernières entrées
        $moods = $moodRepository->findByMoodContainerLast30Entries($moodContainer);

        // Tri des humeurs par ordre décroissant
        usort($moods, function ($a, $b) {
            return $b->getDate() <=> $a->getDate();
        });

        // Calcul la moyenne de l'humeur sur les 7 dernières entrées
        $moodAverage = $moodService->getMoodAverage($moods);

        // Calcul la moyenne de la qualité du sommeil
        $sleepAverage = $moodService->getSleepAverage($moods);

        // Calcul des données pour le graphique
        $labels    = [];
        $moodData  = [];

        foreach ($moods as $mood) {
            $labels[] = $mood->getDate()->format('Y-m-d'); // formatage de la date
            $moodData[] = $mood->getDayMood(); // ou la valeur de l'humeur
        }

        // Pagination
        $paginatedMoods = $paginator->paginate(
            $moods,
            $request->query->getInt('page', 1),
            7
        );

        return $this->render('mood/index.html.twig', [
            'moods'        => $paginatedMoods,
            'moodAverage'  => $moodAverage,
            'sleepAverage' => $sleepAverage,
            'labels'       => json_encode($labels),
            'moodData'     => json_encode($moodData)
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
        $form = $this->createForm(MoodType::class, $mood, [
            'attr' => ['class' => 'custom-form']
        ]);
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

    #[Route('/voir/{id}', name: 'mood_show', methods: ['GET'])]
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

            $this->addFlash('success', 'Humeur modifiée');
            return $this->redirectToRoute('mood_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mood/edit.html.twig', [
            'mood' => $mood,
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'mood_delete')]
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

    #[Route('/voir/stats', name: 'mood_stats')]
    public function getStats(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $moods      = $user->getMoodContainer()->getMoods();
        $moodsArray = [];

        foreach ($moods as $mood) {
            $moodsArray[$mood->getdate()->format('M')] = $mood->getDaymood();
        };

        ksort($moodsArray);
        $moodsArrayJson = json_encode($moodsArray);

        return $this->render('mood/stats.html.twig', [
            'moodsArrayJson' => $moodsArrayJson
        ]);
    }
}
