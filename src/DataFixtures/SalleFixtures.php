<?php

namespace App\DataFixtures;

use App\Entity\Salle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SalleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 10; $i++) {
            $salle[$i] = new Salle();
            $salle[$i]->setTitle('Salle numéro:' . $i)->setContent('This is the content for the Salle: ' . $i);
            $manager->persist($salle[$i]);
        }

        $manager->flush();
    }
}
