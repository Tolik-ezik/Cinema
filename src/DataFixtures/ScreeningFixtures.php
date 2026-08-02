<?php

namespace App\DataFixtures;

use App\Entity\Screening;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ScreeningFixtures extends Fixture implements DependentFixtureInterface
{
    public const Screenig = 'screening1';
    public function load(ObjectManager $manager): void
    {
        $screening = new Screening();
        $screening->setMovie($this->getReference(MovieFixtures::MOVIE_1, \App\Entity\Movie::class));
        $screening->setHall($this->getReference(HallFixtures::HALL_1, \App\Entity\Hall::class));
        $screening->setStartAt(new DateTimeImmutable('2026-08-09 18:00'));
        $screening->setPrice(400);
        $screening->setStatus('active');
        $manager->persist($screening);
        $this->addReference(self::Screenig, $screening);

        $manager->flush();
    }

    public function getDependencies(): array{
        return [MovieFixtures::class, HallFixtures::class];
    }
}
