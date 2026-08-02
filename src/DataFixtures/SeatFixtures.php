<?php

namespace App\DataFixtures;

use App\Entity\Seat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeatFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $hall1 = $this->getReference(HallFixtures::HALL_1, \App\Entity\Hall::class);

        for ($row = 1; $row <= 5; $row++) {
            for ($num = 1; $num <= 8; $num++) {
                $seat = new Seat();
                $seat->setRowNumber($row);
                $seat->setSeatNumber($num);
                $seat->setSeatType($row === 5 ? "vip" : "standart");
                $seat->setHall($hall1);
                $manager->persist($seat);
            }
        }
        

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [HallFixtures::class];
    }
}
