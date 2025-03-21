<?php

namespace App\DataFixtures;

use App\Entity\CaseM;
use App\Entity\Mot;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Liste des mots avec leurs définitions, positions et orientation
        $mots = [
            ['mot' => 'SUBSTANCE', 'definition' => 'Toute sorte de matière.', 'x' => 7, 'y' => 2, 'horizontal' => true],
            ['mot' => 'CORPS', 'definition' => 'Ensemble des parties physiques d’un être vivant.', 'x' => 3, 'y' => 2, 'horizontal' => false],
            ['mot' => 'HUMAIN', 'definition' => 'Un être comme toi et moi.', 'x' => 2, 'y' => 8, 'horizontal' => false],
            ['mot' => 'DENTS', 'definition' => 'Petits os dans la bouche servant à mâcher.', 'x' => 6, 'y' => 10, 'horizontal' => true],
            ['mot' => 'EPIDERME', 'definition' => 'Couche externe de la peau.', 'x' => 3, 'y' => 10, 'horizontal' => false],
            ['mot' => 'NETTOYER', 'definition' => 'Enlever la saleté.', 'x' => 10, 'y' => 4, 'horizontal' => true],
            ['mot' => 'PARFUMER', 'definition' => 'Appliquer une odeur agréable.', 'x' => 3, 'y' => 4, 'horizontal' => true],
            ['mot' => 'PROTEGER', 'definition' => 'Mettre à l’abri d’un danger.', 'x' => 3, 'y' => 13, 'horizontal' => false],

        ];

        // Tableau pour stocker les cases partagées
        $casesPartagees = [];

// Créer les mots et leurs cases
        foreach ($mots as $index => $data) {
            $mot = new Mot();
            $mot->setMot($data['mot']);
            $mot->setDefinition($data['definition']);
            $mot->setHorizontal($data['horizontal']);
            $mot->setLongueur(strlen($data['mot']));
            $manager->persist($mot);

            for ($i = 0; $i < strlen($data['mot']); $i++) {
                // Calculer les coordonnées de la case
                $x = $data['x'] + ($data['horizontal'] ? 0 : $i);
                $y = $data['y'] + ($data['horizontal'] ? $i : 0);

                // Vérifier si la case est partagée
                $caseKey = "{$x}_{$y}";
                if (isset($casesPartagees[$caseKey])) {
                    // Si la case est partagée, on la marque comme partagée pour les deux mots
                    $casesPartagees[$caseKey]->setCasePartage(true);
                }

                // Créer une nouvelle instance de CaseM pour chaque mot
                $case = new CaseM();
                $case->setPositionX($x);
                $case->setPositionY($y);
                $case->setContenu($data['mot'][$i]);
                $case->setAffiche(true);
                if ($i === 0) {
                    $case->setNumero($index + 1); // Numéroter la première case du mot
                }
                $case->setCasePartage(isset($casesPartagees[$caseKey])); // Marquer comme partagée si la case existe déjà
                $manager->persist($case);

                // Ajouter la case au mot et vice-versa
                $case->addMot($mot);
                $mot->addCase($case);

                // Enregistrer la case dans le tableau des cases partagées
                $casesPartagees[$caseKey] = $case;
            }
        }

// E



        // Enregistrer toutes les entités en base de données
        $manager->flush();
    }
}