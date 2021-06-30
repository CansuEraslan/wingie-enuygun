<?php

namespace App\DataFixtures;

use App\Entity\Developer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DeveloperFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $developer = new Developer();
            $developer->setName('Developer ' . $i);
            $developer->setTime(0);
            $developer->setDifficulty($i);
            $manager->persist($developer);
        }

        $manager->flush();
    }
}
