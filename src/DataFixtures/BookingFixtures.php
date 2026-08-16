<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use App\Entity\Seat;
use App\Entity\Ticket;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $booking = new Booking();
        $booking->setCreateAt(new \DateTimeImmutable());
        $booking->setTotalPrice(600);
        $booking->setStatus('paid');
        $booking->setOwner($this->getReference(UserFixtures::Ivan, \App\Entity\User::class));
        $manager->persist($booking);

        $ticket = new Ticket();
        $ticket->setBooking($booking);
        $ticket->setScreening($this->getReference(ScreeningFixtures::Screenig, \App\Entity\Screening::class));
        $ticket->setSeat($manager->getRepository(Seat::class)->findOneBy([]));
        $ticket->setPrice(300);
        $ticket->setStatus('confirmed');
        $manager->persist($ticket);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ScreeningFixtures::class,
            SeatFixtures::class,  
        ];
    }
}
