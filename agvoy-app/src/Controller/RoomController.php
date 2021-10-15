<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RegionRepository;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/room")
 */
class RoomController extends AbstractController
{
    /**
     * @Route("/list", name="room_index", methods={"GET"})
     */
    public function index(RoomRepository $roomRepository, RegionRepository $regionRepository): Response
    {
        return $this->render('room/index.html.twig', [
            'rooms' => $roomRepository->findAll(),
            'regions' => $regionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="room_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($room);
            $entityManager->flush();

            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'Room successfully added');

            return $this->redirectToRoute('room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('room/new.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="room_show", methods={"GET"})
     */
    public function show(Room $room): Response
    {
        return $this->render('room/show.html.twig', [
            'room' => $room,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="room_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Room $room): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'Room successfully modified');

            return $this->redirectToRoute('room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('room/edit.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="room_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Room $room): Response
    {
        if ($this->isCsrfTokenValid('delete' . $room->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($room);
            $entityManager->flush();

            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'Room successfully deleted');
        }

        return $this->redirectToRoute('room_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Add a room to cart
     * 
     * @Route("/cart/{id}", name="room_to_cart", requirements={ "id": "\d+"}, methods="GET")
     */
    public function markAction(Room $room): Response
    {
        $id = $room->getId();

        $cart = $this->get('session')->get('cart');

        if (!is_array($cart)) {
            $cart = array();
            $this->get('session')->set('cart', $cart);
        }

        if (!in_array($id, $cart)) {
            $cart[] = $id;
        } else
        // sinon, le retirer du tableau
        {
            $cart = array_diff($cart, array($id));
        }

        //on enregistre la liste dans la session
        $this->get('session')->set('cart', $cart);

        // Make sure message will be displayed after redirect
        $this->get('session')->getFlashBag()->add('message', 'Room successfully added to cart');

        return $this->redirectToRoute(
            'room_show',
            ['id' => $room->getId()]
        );
    }
}
