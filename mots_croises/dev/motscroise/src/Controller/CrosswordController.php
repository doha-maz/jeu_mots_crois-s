<?php

namespace App\Controller;

use App\Entity\CaseM;
use App\Entity\Mot;
use App\Repository\CaseMRepository;
use App\Repository\MotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
                    'mot' => null,
                    'numero' => null,
                ];
            }
        }

        foreach ($mots as $mot) {
            $cases = $mot->getCases();
            foreach ($cases as $case) {
                $x = $case->getPositionX();
                $y = $case->getPositionY();
                $grille[$x][$y]['contenu'] = $case->getContenu();
                $grille[$x][$y]['mot'] = $mot;
                if ($case->getNumero()) {
                    $grille[$x][$y]['numero'] = $case->getNumero();
                }
            }
        }
        return $this->render('crossword/grid.html.twig', [
            'grille' => $grille,
        ]);
    }

    #[Route('/definition/{id}', name: 'get_definition')]
    public function getDefinition(int $id, EntityManagerInterface $em): JsonResponse
    {
        $mot = $em->getRepository(Mot::class)->find($id);
        if (!$mot) return new JsonResponse(['error' => 'Mot non trouvé'], 404);

        return new JsonResponse(['definition' => $mot->getDefinition()]);
    }

    #[Route('/validate/{id}', name: 'validate_answer', methods: ['POST'])]
    public function validateAnswer(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $mot = $em->getRepository(Mot::class)->find($id);
        if (!$mot) return new JsonResponse(['error' => 'Mot non trouvé'], 404);

        $isCorrect = strtoupper($data['answer']) === strtoupper($mot->getMot());

        if ($isCorrect) {
            $cases = $em->getRepository(CaseM::class)->findBy(['mot' => $mot]);
            $word = $mot->getMot();
            foreach ($cases as $index => $case) {
                $case->setContenu($word[$index]);
            }
            $em->flush();
        }

        return new JsonResponse(['correct' => $isCorrect]);
    }

}
