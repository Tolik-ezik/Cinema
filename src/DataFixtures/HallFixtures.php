<?php

namespace App\DataFixtures;

use App\Entity\Hall;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HallFixtures extends Fixture 
{
    public const HALL_1 = 'hall-1';
    public const HALL_2 = 'hall-2';


    public function load(ObjectManager $manager): void
    {
        $hall1 = new Hall();
        $hall1->setname('Зал 1');
        $hall1->setCapacity(40);
        $hall1->setType('standart');
        $manager->persist($hall1);
        $this->addReference(self::HALL_1, $hall1);

        $hall2 = new Hall();
        $hall2->setname('Зал 2');
        $hall2->setCapacity(20);
        $hall2->setType('Vip');
        $manager->persist($hall2);
        $this->addReference(self::HALL_2, $hall2);

        $manager->flush();
    }
}
