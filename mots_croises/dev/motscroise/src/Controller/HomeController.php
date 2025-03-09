<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/previous', name: 'game_commencer')]
    public function start(): Response
    {
        return $this->render('previous/commencer.html.twig');
    }

    #[Route('/definition', name: 'game_definition')]
    public function definition(): Response
    {
        return $this->render('definition/definition.html.twig');
    }

}

