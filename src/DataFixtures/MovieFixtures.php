<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public const MOVIE_1 = 'movie-1';

    public function load(ObjectManager $manager): void
    {
        $comedy  = $this->getReference(GenreFixtures::Comedy,  \App\Entity\Genre::class);
        $drama  = $this->getReference(GenreFixtures::Drama,  \App\Entity\Genre::class);
        $horror  = $this->getReference(GenreFixtures::Horror,  \App\Entity\Genre::class);
        $fantasy  = $this->getReference(GenreFixtures::Fantasy,  \App\Entity\Genre::class);


        $movie1 = new Movie();
        $movie1->setTitle('Матрица');
        $movie1->setDescription('Культовый фильм');
        $movie1->setDuration(136);
        $movie1->setAgeRating('16+');
        $movie1->setposter('aa.jpg');
        $movie1->setIsActive(true);
        $movie1->addGenre([$fantasy, $drama]);
        $manager->persist($movie1);
        $this->addReference(self::MOVIE_1, $movie1);

        $movie2 = new Movie();
        $movie2->setTitle('Один дома');
        $movie2->setDescription('Семейный фильм');
        $movie2->setDuration(103);
        $movie2->setAgeRating('6+');
        $movie2->setposter('ab.jpg');
        $movie2->setIsActive(true);
        $movie2->addGenre($comedy);
        $manager->persist($movie2);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [GenreFixtures::class];
    }
}
