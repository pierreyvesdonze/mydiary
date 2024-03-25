<?php

namespace App\Controller;

use App\Repository\BookContentRepository;
use App\Repository\BookRepository;
use App\Repository\DateRepository;
use App\Repository\MoodRepository;
use App\Repository\UserRepository;
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
}
