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
        $mots = [
            ['mot' => 'SUBSTANCE', 'definition' => 'Matière qui compose un objet ou un être.', 'x' => 1, 'y' => 7, 'horizontal' => true],
            ['mot' => 'CORPS', 'definition' => 'Ensemble des parties physiques d’un être vivant.', 'x' => 2, 'y' => 1, 'horizontal' => false],
            ['mot' => 'HUMAIN', 'definition' => 'Qui appartient à l’espèce des hommes.', 'x' => 3, 'y' => 3, 'horizontal' => false],
            ['mot' => 'EPIDERME', 'definition' => 'Couche externe de la peau.', 'x' => 5, 'y' => 5, 'horizontal' => false],
            ['mot' => 'DENTS', 'definition' => 'Petits os dans la bouche servant à mâcher.', 'x' => 5, 'y' => 7, 'horizontal' => true],
            ['mot' => 'NETTOYER', 'definition' => 'Enlever la saleté.', 'x' => 6, 'y' => 1, 'horizontal' => true],
            ['mot' => 'PARFUMER', 'definition' => 'Appliquer une odeur agréable.', 'x' => 7, 'y' => 2, 'horizontal' => true],
            ['mot' => 'PROTEGER', 'definition' => 'Mettre à l’abri d’un danger.', 'x' => 8, 'y' => 4, 'horizontal' => false],
        ];

        foreach ($mots as $data) {
            $mot = new Mot();
            $mot->setMot($data['mot']);
            $mot->setDefinition($data['definition']);
            $mot->setHorizontal($data['horizontal']);
            $mot->setLongueur(strlen($data['mot']));
            $manager->persist($mot);

            for ($i = 0; $i < strlen($data['mot']); $i++) {
                $case = new CaseM();
                if ($data['horizontal']) {
                    $case->setPositionX($data['x'] + $i);
                    $case->setPositionY($data['y']);
                } else {
                    $case->setPositionX($data['x']);
                    $case->setPositionY($data['y'] + $i);
                }
                $case->setContenu(' ');
                $case->setAffiche(true);
                $case->addMot($mot);
                $mot->addCase($case);
                $manager->persist($case);
            }
        }




        $manager->flush();
    }
}
