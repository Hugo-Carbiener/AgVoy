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
}
