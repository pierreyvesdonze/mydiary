<?php

namespace App\Controller;

use App\Repository\BookContentRepository;
use App\Repository\BookRepository;
use App\Repository\DateRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FriendProfileController extends AbstractController
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    #[Route('/contact/profile/index/{user2}', name: 'friend_profile_index')]
    public function index($user2): Response
    {
        $friendProfile = $this->userRepository->findOneBy([
            'id' => $user2
        ]);

        return $this->render('friend_profile/index.html.twig', [
            'friendProfile' => $friendProfile,
        ]);
    }

    #[Route('/contact/journal/{friend}', name: 'book_friend', methods: ['GET'])]
    public function book(
        $friend,
        BookRepository $bookRepository,
        BookContentRepository $bookContentRepository,
        UserRepository $userRepository
    )
    {
        $friendUser = $userRepository->findOneBy([
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

    #[Route('/contact/dates/{friend}', name: 'dates_friend', methods: ['GET'])]
    public function dates(
        $friend,
        DateRepository $dateRepository,
        UserRepository $userRepository,
    ): Response {

        $friendUser = $userRepository->findOneBy([
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
}
