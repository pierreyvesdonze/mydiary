<?php

namespace App\Controller;

use App\Entity\BookContent;
use App\Form\BookContentType;
use App\Repository\BookContentRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book/content')]
class BookContentController extends AbstractController
{
    #[Route('/new', name: 'book_content_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
        ): Response
    {
        $book        = $this->getUser()->getBook();
        $bookContent = new BookContent();
        $bookContent->setBook($book);
        $bookContent->setCreatedAt(new \DatetimeImmutable());
        
        $form = $this->createForm(BookContentType::class, $bookContent);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bookContent);
            $entityManager->flush();

            $this->addFlash('success', 'Nouvelle entrée créée avec succès !');

            return $this->redirectToRoute('book_show', [
                'id' => $book->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book_content/new.html.twig', [
            'book_content' => $bookContent,
            'form'         => $form,
            'book'         => $book
        ]);
    }

    #[Route('/{id}', name: 'book_content_show', methods: ['GET'])]
    public function show(BookContent $bookContent): Response
    {
        return $this->render('book_content/show.html.twig', [
            'book_content' => $bookContent,
        ]);
    }

    #[Route('/{id}/edit', name: 'book_content_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        BookContent $bookContent,
        EntityManagerInterface $entityManager
        ): Response
    {
        $book = $bookContent->getBook();
        $form = $this->createForm(BookContentType::class, $bookContent);

        $bookContent->setUpdatedAt(new \DatetimeImmutable());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Contenu modifié avec succès');

            return $this->redirectToRoute('book_show', [
                'id' => $book->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book_content/edit.html.twig', [
            'book_content' => $bookContent,
            'book'         => $book,
            'form'         => $form,
        ]);
    }

    #[Route('/{id}', name: 'book_content_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        BookContent $bookContent,
        EntityManagerInterface $entityManager
        ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookContent->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bookContent);
            $entityManager->flush();

            $this->addFlash('success', 'Contenu supprimé !');
        }

        return $this->redirectToRoute('book_show', [
            'id' => $bookContent->getBook()->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
