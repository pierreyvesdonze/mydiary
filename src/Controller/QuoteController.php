<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteType;
use App\Repository\QuoteRepository;
use App\Service\QuoteService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class QuoteController extends AbstractController
{
    #[Route('/citations', name: 'quotes')]
    public function index(
        QuoteRepository $quoteRepository,
        Request $request,
        EntityManagerInterface $em,
        QuoteService $quoteService,
    ): Response {

        $quotes      = $quoteRepository->findAll();
        $randomQuote = $quoteRepository->findRandomQuote();
        $newQuote    = new Quote();

        $form = $this->createForm(QuoteType::class, $newQuote, [
            'attr' => ['class' => 'quote-type']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userQuote = $form->get('text')->getData();
            
            if ($quoteService->isExist($quotes, $userQuote) == false) {
                $em->persist($newQuote);
                $em->flush();

                $this->addFlash('success', 'Et une nouvelle citation !');
                return $this->redirectToRoute('quotes', [], Response::HTTP_SEE_OTHER);
            }

            $this->addFlash('error', 'Une citation similaire existe !');
            return $this->redirectToRoute('quotes', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quote/index.html.twig', [
            'randomQuote' => $randomQuote,
            'form'  => $form->createView()
        ]);
    }
}
