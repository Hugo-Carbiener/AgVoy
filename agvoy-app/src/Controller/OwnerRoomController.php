<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/owner/room")
 */
class OwnerRoomController extends AbstractController
{
    /**
     * @Route("/list", name="owner_room_index", methods={"GET"})
     */
    public function index(RoomRepository $roomRepository): Response
    {
        return $this->render('owner_room/index.html.twig', [
            'rooms' => $roomRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="owner_room_new", methods={"GET","POST"})
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
            $this->get('session')->getFlashBag()->add('message', 'Room added');

            return $this->redirectToRoute('owner_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('owner_room/new.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="owner_room_show", methods={"GET"})
     */
    public function show(Room $room): Response
    {
        return $this->render('owner_room/show.html.twig', [
            'room' => $room,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="owner_room_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Room $room): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'Room modified');

            return $this->redirectToRoute('owner_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('owner_room/edit.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="owner_room_delete", methods={"POST"})
     */
    public function delete(Request $request, Room $room): Response
    {
        if ($this->isCsrfTokenValid('delete' . $room->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($room);
            $entityManager->flush();

            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'Room deleted');
        }

        return $this->redirectToRoute('owner_room_index', [], Response::HTTP_SEE_OTHER);
    }
}
