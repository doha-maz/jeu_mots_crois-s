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
            ['mot' => 'SUBSTANCE', 'definition' => 'Matière qui compose un objet ou un être.', 'x' => 7, 'y' => 2, 'horizontal' => true],
            ['mot' => 'CORPS', 'definition' => 'Ensemble des parties physiques d’un être vivant.', 'x' => 3, 'y' => 2, 'horizontal' => false],
            ['mot' => 'HUMAIN', 'definition' => 'Qui appartient à l’espèce des hommes.', 'x' => 2, 'y' => 8, 'horizontal' => false],
            ['mot' => 'EPIDERME', 'definition' => 'Couche externe de la peau.', 'x' => 3, 'y' => 10, 'horizontal' => false],
            ['mot' => 'DENTS', 'definition' => 'Petits os dans la bouche servant à mâcher.', 'x' => 6, 'y' => 10, 'horizontal' => true],
            ['mot' => 'NETTOYER', 'definition' => 'Enlever la saleté.', 'x' => 10, 'y' => 4, 'horizontal' => true],
            ['mot' => 'PARFUMER', 'definition' => 'Appliquer une odeur agréable.', 'x' => 3, 'y' => 4, 'horizontal' => true],
            ['mot' => 'PROTEGER', 'definition' => 'Mettre à l’abri d’un danger.', 'x' => 3, 'y' => 13, 'horizontal' => false],
        ];

        foreach ($mots as $index => $data) {
            $mot = new Mot();
            $mot->setMot($data['mot']);
            $mot->setDefinition($data['definition']);
            $mot->setHorizontal($data['horizontal']);
            $mot->setLongueur(strlen($data['mot']));
            $manager->persist($mot);

            for ($i = 0; $i < strlen($data['mot']); $i++) {
                $case = new CaseM();
                if ($data['horizontal']) {
                    $case->setPositionX($data['x']);
                    $case->setPositionY($data['y'] + $i);
                } else {
                    $case->setPositionX($data['x'] + $i);
                    $case->setPositionY($data['y']);
                }
                $case->setContenu($data['mot'][$i]);
                $case->setAffiche(true);
                if ($i === 0) {
                    $case->setNumero($index + 1);
                }
                $case->addMot($mot);
                $mot->addCase($case);
                $manager->persist($case);
            }
        }




        $manager->flush();
    }
}
