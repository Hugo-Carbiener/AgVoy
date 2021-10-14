<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class Controller extends AbstractController
{
    /**
     * @Route("", name="homepage", methods={"GET"})
     */
    public function homepage(RoomRepository $roomRepository): Response
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/cart", name="cart", methods={"GET"})
     */
    public function index(RoomRepository $roomRepository): Response
    {
        $cart = $this->get('session')->get('cart');
        $rooms = array();

        if (!empty($cart)) {
            foreach ($cart as $id) {
                $room = $roomRepository->findOneBy(['id' => $id]);
                $rooms[] = $room;
            }
        }

        return $this->render('cart.html.twig', [
            'rooms' => $rooms,
        ]);
    }
}
