<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UserController extends AbstractController
{
    #[Route('/home/{id}', name: 'home')]
    #[IsGranted('ROLE_USER')]
    public function index(BookingRepository $bookingRepository, EntityManagerInterface $em): Response
    {
        $booking = $bookingRepository->findBy(
            ['owner' => $this->getUser()],
            ['createAt' => 'DESC']);
        return $this->render('user/index.html.twig', [
            'bookings' => $booking,
        ]);
    }
}
