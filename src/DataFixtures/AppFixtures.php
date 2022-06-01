<?php

namespace App\DataFixtures;

use App\Entity\Catalog;
use App\Entity\Title;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $catalog = new Catalog();
            $titleNumber = rand(min: 1, max: 12);
            $catalog->setName("catalog $i");

            for ($j = 0; $j < $titleNumber; $j++) {
                $title = new Title();
                $title->setTitle("title $i $j")
                    ->setRating(rand(min: 1, max: 5))
                    ->setYear(rand(min: 2000, max: 2022))
                    ->setCatalog($catalog);
                $manager->persist($title);
            }
            $manager->persist($catalog);
        }

        $manager->flush();
    }
}
