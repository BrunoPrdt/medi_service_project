<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Reservations;
use App\Form\BookingType;
use App\Form\ReservationsType;
use App\Repository\ReservationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/reservations")
 */
class ReservationsController extends AbstractController
{
    /**
     * @Route("/", name="reservations_index", methods={"GET"})
     * @param ReservationsRepository $reservationsRepository
     * @return Response
     */
    public function index(ReservationsRepository $reservationsRepository): Response
    {
        return $this->render('admin/reservations/index.html.twig', [
            'reservations' => $reservationsRepository->findLastestQuery(),
            'current_menu' => 'reservations_active',
        ]);
    }

    /**
     * @Route("/new", name="reservations_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $reservation = new Reservations();
        $form = $this->createForm(ReservationsType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Si les dates ne sont pas disponbles, message d'erreur
            if (!$reservation->isAvailableDate()){
                $this->addFlash(
                    'warning',
                    'Les dates choisies sont indisponibles'
                );
            } else {
                // Sinon enregistrement et redirection

                //$entityManager->persist($reservation);
                //$entityManager->flush();

                return $this->redirectToRoute('reservations_index');
            }
        }

        return $this->render('admin/reservations/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
            'current_menu' => 'reservations_active',
        ]);
    }

    /**
     * @Route("{id}/newBooking", name="article_reservation", methods={"GET","POST"})
     * @param Request $request
     * @param Articles $articles
     * @return Response
     */
    public function newReservation(Request $request, Articles $articles): Response
    {
        $booking = new Reservations();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Si les dates ne sont pas disponbles, message d'erreur
            if (!$booking->isAvailableDate()){
                $this->addFlash(
                    'warning',
                    'Les dates choisies sont indisponibles'
                );
            } else {
                // Sinon enregistrement et redirection

                if ($this->isCsrfTokenValid('booking', $request->request->get('_token'))) {
                    //$entityManager->persist($booking);
                    //$entityManager->flush();
                    return $this->redirectToRoute('reservations_index');
                }
             }
        }
        return $this->render('admin/reservations/newBooking.html.twig', [
            'article' => $articles,
            'reservation' => $booking,
            'form' => $form->createView(),
            'current_menu' => 'reservations_active',
        ]);
    }

    /**
     * @Route("/{id}", name="reservations_show", methods={"GET"})
     * @param Reservations $reservation
     * @return Response
     */
    public function show(Reservations $reservation): Response
    {
        return $this->render('admin/reservations/show.html.twig', [
            'reservation' => $reservation,
            'current_menu' => 'reservations_active',
        ]);
    }

    /**
     * @Route("/{id}/user_reservation", name="show_user_reservation", methods={"GET"})
     * @param ReservationsRepository $reservationsRepository
     * @param Request $request
     * @return Response
     */
    public function showUserReservation(ReservationsRepository $reservationsRepository, Request $request): Response
    {
        $user = $request->get('id');
        return $this->render('admin/userReservations/show.html.twig', [
            'reservations' => $reservationsRepository->findUserReservation($user),
            'current_menu' => 'reservations_active',

        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservations_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Reservations $reservation
     * @return Response
     */
    public function edit(Request $request, Reservations $reservation): Response
    {
        $form = $this->createForm(ReservationsType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservations_index');
        }

        return $this->render('admin/reservations/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
            'current_menu' => 'reservations_active',
        ]);
    }

    /**
     * @Route("/{id}", name="reservations_delete", methods={"DELETE"})
     * @param Request $request
     * @param Reservations $reservation
     * @return Response
     */
    public function delete(Request $request, Reservations $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            //$entityManager->remove($reservation);
            //$entityManager->flush();
        }

        return $this->redirectToRoute('reservations_index');
    }
}
