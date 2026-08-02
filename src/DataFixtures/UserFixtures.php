<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Command\UserPasswordHashCommand;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const Ivan = 'ivan';

    public function __construct(private UserPasswordHasherInterface $passvordHasher) {}
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('admin@gmail.com');
        $user1->setRoles(['ROLE_ADMIN']);
        $user1->setPassword($this->passvordHasher->hashPassword($user1, 'admin123'));
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('user@gmail.com');
        $user2->setRoles(['ROLE_USER']);
        $user2->setPassword($this->passvordHasher->hashPassword($user2, 'password123'));
        $manager->persist($user2);
        $this->addReference(self::Ivan, $user2);

        $manager->flush();
    }
}
