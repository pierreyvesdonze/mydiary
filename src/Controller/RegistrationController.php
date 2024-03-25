<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Dates;
use App\Entity\DatesContainer;
use App\Entity\MoodContainer;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em
        )
    {
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();

        if($this->getUser()) {
            $this->addFlash('error', 'Vous êtes déjà enregistré et connecté.');
            return $this->redirectToRoute('home');
        }

        // Create book for User
        $book = new Book;
        $book->setVisibility(0);
        $user->setBook($book);
        $this->em->persist($book);

        // Create Dates object (parent of Date object)
        $datesContainer = new DatesContainer();
        $datesContainer->setVisibility(0);
        $user->setDatesContainer($datesContainer);
        $this->em->persist($datesContainer);

        // Create MoodContainer object (Mood's parent)
        $moodContainer = new MoodContainer();
        $moodContainer->setVisibility(0);
        $user->setMoodContainer($moodContainer);
        $this->em->persist($moodContainer);
        
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_USER']);
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
