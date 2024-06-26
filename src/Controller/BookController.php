<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\BookDiaryContent;
use App\Form\BookType;
use App\Repository\BookContentRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/journal')]
class BookController extends AbstractController
{
    
    #[Route('/nouveau', name: 'book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {   
        $user = $this->getUser();
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
                
        if ($form->isSubmitted() && $form->isValid()) {
            $book->setUser($user);
            $book->setVisibility(0);

            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('book_show', [
                'id' => $book->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'book_show', methods: ['GET'])]
    public function show(
        Book $book,
        BookContentRepository $bookContentRepository,
        PaginatorInterface $paginator,
        Request $request,
        ): Response
    {
        $bookContents = $bookContentRepository->findBookContentByDesc($book);

         // Pagination
         $paginated = $paginator->paginate(
            $bookContents,
            $request->query->getInt('page', 1),
            7
         );

        return $this->render('book/show.html.twig', [
            'book'         => $book,
            'bookContents' => $paginated
        ]);
    }

    #[Route('/modifier/{id}', name: 'book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        if ($book->getUser() !== $user) {
            $this->addFlash('error', "Vous ne pouvez pas écrire dans le journal d'un autre");
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('book_show', [
                'id' => $book->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'book_delete', methods: ['POST'])]
    public function delete(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        if ($book()->getUser() !== $user) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer ce journal.');

            return $this->redirectToRoute('home');
        }

        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
