<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    public const Comedy = 'Comedy';
    public const Drama = 'Drama';
    public const Horror = 'Horror';
    public const Fantasy = 'Fantasy';


    public function load(ObjectManager $manager): void
    {
        $genres = [
            self::Comedy => 'Комедия',
            self::Drama => 'Драма',
            self::Horror => 'Хоррор',
            self::Fantasy => 'Фентези',
        ];
        foreach ($genres as $referense => $name) {
            $genre = new Genre();
            $genre->setName($name);
            $manager->persist($genre);

            $this->addReference($referense, $genre);
        }


        $manager->flush();
    }
}
