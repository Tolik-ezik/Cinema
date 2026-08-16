<?php

namespace App\Controller;

use App\DataFixtures\UserFixtures;
use App\Entity\Booking;
use App\Entity\Screening;
use App\Entity\Seat;
use App\Entity\Ticket;
use App\Repository\SeatRepository;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ScreeningController extends AbstractController
{
    #[Route('/screening/{id}', name: 'screening')]
    public function index(Screening $screening, EntityManagerInterface $em): Response
    {
        $seats = $em->getRepository(Seat::class)->findBy(
            ['hall' => $screening->getHall()],
            ['rowNumber' => 'ASC', 'seatNumber' => 'ASC']
        );

        $takenSeatId = $em->getRepository(Ticket::class)
            ->createQueryBuilder('t')
            ->select('IDENTITY(t.seat)')
            ->where('t.screening = :screening')
            ->andWhere('t.status != :cancelled')
            ->setParameter('screening', $screening)
            ->setParameter('cancelled', 'cancelled')
            ->getQuery()
            ->getSingleColumnResult();

        return $this->render('screening.html.twig', [
            'screening' => $screening,
            'seats' => $seats,
            'takenSeatId' => $takenSeatId,
        ]);
    }

    #[Route('/screening/{id}/book', name: 'booking_create', methods: ['POST'])]

    public function bookingCreate(Screening $screening, Request $request, SeatRepository $seatRepository, TicketRepository $ticketRepository, EntityManagerInterface $em)
    {
        $seatIds = $request->request->all('seats');
        if (empty($seatIds)) {
            $this->addFlash('error', 'Выберете хоть одно место');
            return $this->redirectToRoute('screening', ['id' => $screening->getId()]);
        }

        $takenSeatId = $em->getRepository(Ticket::class)
            ->createQueryBuilder('t')
            ->select('IDENTITY(t.seat)')
            ->where('t.screening = :screening')
            ->andWhere('t.seat IN (:seatIds)')
            ->setParameter('screening', $screening)
            ->setParameter('seatIds', $seatIds)
            ->getQuery()
            ->getSingleColumnResult();

        if (!empty($takenSeatId)) {
            $this->addFlash('error', 'Одно из мест уже занято');
            return $this->redirectToRoute('screening', ['id' => $screening->getId()]);
        }

        $booking = new Booking();
        $booking->setOwner($this->getUser());
        $booking->setCreateAt(new \DateTimeImmutable());
        $booking->setTotalPrice(count($seatIds) * $screening->getPrice());
        $booking->setStatus('paid');
        $em->persist($booking);

        foreach ($seatIds as $seatId) {
            $seat = $seatRepository->find($seatId);

            $ticket = new Ticket();
            $ticket->setBooking($booking);
            $ticket->setScreening($screening);
            $ticket->setSeat($seat);
            $ticket->setPrice($seat->getSeatType() === 'vip' ? 700 : 500);
            $ticket->setStatus('confirmed');
            $em->persist($ticket);
        }
        $em->flush();


        $this->addFlash('success', 'Билеты успешно куплены!');
        return $this->redirectToRoute('index');
        // return $this->redirectToRoute('booking_success', ['id' => $booking->getId()]);
    }
}
