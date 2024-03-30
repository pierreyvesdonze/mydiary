<?php

namespace App\Controller;

use App\Repository\BloodTypeRepository;
use App\Repository\BookContentRepository;
use App\Repository\BookRepository;
use App\Repository\DateRepository;
use App\Repository\HealthConditionRepository;
use App\Repository\HeightRepository;
use App\Repository\MedicationRepository;
use App\Repository\MoodRepository;
use App\Repository\RoutineRepository;
use App\Repository\UserRepository;
use App\Repository\VaccineRepository;
use App\Repository\WeightRepository;
use App\Service\HealthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contact')]
class FriendProfileController extends AbstractController
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    #[Route('/profile/index/{user2}', name: 'friend_profile_index')]
    public function index($user2): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $friendUser = $this->userRepository->findOneBy([
            'id' => $user2
        ]);

        return $this->render('friend_profile/index.html.twig', [
            'friendUser' => $friendUser,
        ]);
    }

    #[Route('/journal/{friend}', name: 'book_friend', methods: ['GET'])]
    public function book(
        $friend,
        BookRepository $bookRepository,
        BookContentRepository $bookContentRepository
    )
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $friendUser = $this->userRepository->findOneBy([
            'id' => $friend
        ]);

        $book = $bookRepository->findBy([
            'user' => $friendUser
        ]);

        $bookContents = $bookContentRepository->findBookContentByDesc($book);

        return $this->render('friend_profile/book.html.twig', [
            'book'         => $book,
            'bookContents' => $bookContents,
            'friendUser'   => $friendUser
        ]);
    }

    #[Route('/dates/{friend}', name: 'dates_friend', methods: ['GET'])]
    public function dates(
        $friend,
        DateRepository $dateRepository
    ): Response {

        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $friendUser = $this->userRepository->findOneBy([
            'id' => $friend
        ]);
        $dates = $dateRepository->findBy(['user' => $friendUser]);

        // Trier les dates par année
        usort($dates, function ($a, $b) {
            return $a->getDate()->format('Y') - $b->getDate()->format('Y');
        });

        return $this->render('friend_profile/dates.html.twig', [
            'dates'      => $dates,
            'friendUser' => $friendUser
        ]);
    }

    #[Route('/humeur/{friend}', name: 'mood_friend', methods: ['GET'])]
    public function mood(
        $friend,
        MoodRepository $moodRepository,
    ): Response
    {
        $friendUser    = $this->userRepository->findOneBy(['id' => $friend]);
        $moodContainer = $friendUser->getMoodContainer();
        $moods         = $moodRepository->findByMoodContainer($moodContainer);

        return $this->render('friend_profile/mood.html.twig', [
            'moods'      => $moods,
            'friendUser' => $friendUser
        ]);
    }

    #[Route('/sante/{friend}', name: 'health_friend', methods: ['GET'])]
    public function health(
        $friend,
        WeightRepository $weightRepository,
        HeightRepository $heightRepository,
        BloodTypeRepository $bloodTypeRepository,
        VaccineRepository $vaccineRepository,
        MedicationRepository $medicationRepository,
        HealthConditionRepository $healthConditionRepository,
        HealthService $healthService,
    ): Response
    {
        $friendUser       = $this->userRepository->findOneBy(['id' => $friend]);
        $healthContainer  = $friendUser->getHealthContainer();

        $weights          = $weightRepository->findByHealthContainer($healthContainer);
        $height           = $heightRepository->findByHealthContainer($healthContainer);
        $bloodType        = $bloodTypeRepository->findByHealthContainer($healthContainer);
        $vaccines         = $vaccineRepository->findByHealthContainer($healthContainer);
        $medications      = $medicationRepository->findByHealthContainer($healthContainer);
        $healthConditions = $healthConditionRepository->findByHealthContainer($healthContainer);

        // Formate le poids
        if($height) {
            $formatedHeight = $healthService->formatHeight($height[0]->getValue());
        } else {
            $formatedHeight = null;
        }

        // Calcule l'IMC
        $imc         = null;
        $imcCategory = null;
        if ($height && $weights) {
            $imcArray    = $healthService->getImc($height[0], $weights[0]);
            $imc         = $imcArray[0];
            $imcCategory = $imcArray[1];
        }

        // Tri les vaccins par date décroissante
        if($vaccines) {
            usort($vaccines, function($a, $b) {
                return $b->getInjectionDate() <=> $a->getInjectionDate();
            });
        }

        return $this->render('friend_profile/health.html.twig', [
            'weights'          => $weights,
            'friendUser'       => $friendUser,
            'formatedHeight'   => $formatedHeight,
            'height'           => $height,
            "imc"              => $imc,
            'imcCategory'      => $imcCategory,
            'bloodType'        => $bloodType[0],
            'vaccines'         => $vaccines,
            'medications'      => $medications,
            'healthConditions' => $healthConditions
        ]);
    }

    
    #[Route('/routine/{friend}', name: 'routine_friend', methods: ['GET'])]
    public function routine(
        $friend,
        RoutineRepository $routineRepository,
    ): Response
    {
        $friendUser       = $this->userRepository->findOneBy(['id' => $friend]);
        $routineContainer = $friendUser->getRoutineContainer();
        $routines         = $routineRepository->findByRoutineContainer($routineContainer);

        return $this->render('friend_profile/routines.html.twig', [
            'routines'   => $routines,
            'friendUser' => $friendUser
        ]);
    }
}
