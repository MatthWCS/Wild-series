<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProgramRepository;
use App\Entity\Program;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('program/index.html.twig', ['programs' => $programs,]);
    }

    #[Route('/show/{id<^[0-9]+$>}', requirements: ['id'=>'\d+'], methods: ['GET'], name: 'show')]
    public function show(int $id, ProgramRepository $programRepository):Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);
        // same as $program = $programRepository->find($id);

        if (!$program) {
            throw $this->createNotFoundException(
                "Il n'existe aucune série correspondant à l' id : ".$id
            );
        }
        return $this->render('program/show.html.twig', ['program' => $program,]);
    }
}
