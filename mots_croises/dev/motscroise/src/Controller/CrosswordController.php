<?php

namespace App\Controller;

use App\Repository\MotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CrosswordController extends AbstractController
{
    #[Route('/crossword', name: 'app_crossword')]
    public function showGame(MotRepository $motRepository): Response
    {
        $mots = $motRepository->findAll();
        $grille = [];
        for ($x = 1; $x <= 14; $x++) {
            for ($y = 1; $y <= 14; $y++) {
                $grille[$x][$y] = [
                    'contenu' => '',
                    'mots' => [],
                    'numero' => null,
                    'casePartage' => false,
                ];
            }
        }

        foreach ($mots as $mot) {
            $cases = $mot->getCases();
            foreach ($cases as $case) {
                $x = $case->getPositionX();
                $y = $case->getPositionY();
                $grille[$x][$y]['mots'][] = $mot;
                $grille[$x][$y]['contenu'] = $case->getContenu();
                if ($case->getNumero()) {
                    $grille[$x][$y]['numero'] = $case->getNumero();
                }
                // Si la case est partagée, mettre à jour la clé casePartage
                if ($case->isCasePartage()) {
                    $grille[$x][$y]['casePartage'] = true;
                }
            }
        }
        return $this->render('crossword/grid.html.twig', [
            'grille' => $grille,
        ]);
    }

    #[Route('/congratulations', name: 'app_congratulations')]
    public function congratulations(): Response
    {
        return $this->render('felicitation/congratulation.html.twig');
    }

}
