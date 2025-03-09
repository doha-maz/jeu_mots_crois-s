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

    #[Route('/previous', name: 'game_defintion')]
    public function start(): Response
    {
        return $this->render('previous/definition.html.twig');
    }

    #[Route('/previous/next', name: 'game_next')]
    public function next(): Response
    {
        return $this->render('previous/next.html.twig');
    }

}

