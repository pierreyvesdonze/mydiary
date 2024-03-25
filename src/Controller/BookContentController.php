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
    public function __construct(private EntityManagerInterface $em)
    {}

    #[Route('/new', name: 'book_content_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request
        ): Response
    {
        $book        = $this->getUser()->getBook();
        $bookContent = new BookContent();
        $bookContent->setBook($book);
        $bookContent->setCreatedAt(new \DatetimeImmutable());
        $bookContent->setUpdatedAt(new \DatetimeImmutable());
        
        $form = $this->createForm(BookContentType::class, $bookContent);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($bookContent);
            $this->em->flush();

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
        BookContent $bookContent
        ): Response
    {
        $book = $bookContent->getBook();
        $form = $this->createForm(BookContentType::class, $bookContent);

        $bookContent->setUpdatedAt(new \DatetimeImmutable());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

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

    #[Route('/delete{id}', name: 'book_content_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        BookContent $bookContent
        ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookContent->getId(), $request->request->get('_token'))) {
            $this->em->remove($bookContent);
            $this->em->flush();

            $this->addFlash('success', 'Contenu supprimé !');
        }

        return $this->redirectToRoute('book_show', [
            'id' => $bookContent->getBook()->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
