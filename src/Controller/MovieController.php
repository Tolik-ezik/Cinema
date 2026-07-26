<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MovieController extends AbstractController
{
    #[Route('/', name: 'app_move')]
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();
        return $this->render('move/index.html.twig', [
            'movies' => $movies,
        ]);
    }
}
