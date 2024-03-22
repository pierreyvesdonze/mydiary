<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\FileType;
use App\Repository\FileRepository;
use App\Service\FileManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/file')]
class FileController extends AbstractController
{

    public function __construct(private FileManager $fileManager)
    {
    }

    #[Route('/', name: 'file_index', methods: ['GET'])]
    public function index(FileRepository $fileRepository): Response
    {
        return $this->render('file/index.html.twig', [
            'files' => $fileRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'file_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $file = new File();
        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileUploaded = $form->get('image')->getData();
            $fileName = $this->fileManager->upload($fileUploaded);
            $file->setImage($fileName);
            $entityManager->persist($file);
            $entityManager->flush();

            return $this->redirectToRoute('file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('file/new.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'file_show', methods: ['GET'])]
    public function show(File $file): Response
    {
        return $this->render('file/show.html.twig', [
            'file'      => $file
        ]);
    }

    #[Route('/{id}', name: 'file_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        File $file,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $file->getId(), $request->request->get('_token'))) {

            $this->fileManager->deleteFile($file->getImage());

            $entityManager->remove($file);
            $entityManager->flush();
        }

        return $this->redirectToRoute('file_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route("/download/{filePath}", name: 'file_download', methods: ['GET', 'POST'])]
    public function downloadFile($filePath)
    {
        $response = new BinaryFileResponse($filePath);

        $response->headers->set('Content-Type', 'image/jpg');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filePath
        );
    
        return $response;
    }
}
