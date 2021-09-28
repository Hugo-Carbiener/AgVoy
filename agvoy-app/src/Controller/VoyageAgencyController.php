<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoyageAgencyController extends AbstractController
{
    /**
     * @Route("/voyage/agency", name="voyage_agency")
     */
    public function index(): Response
    {
        return $this->render('voyage_agency/index.html.twig', [
            'controller_name' => 'VoyageAgencyController',
        ]);
    }
}
