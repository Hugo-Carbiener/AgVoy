<?php

namespace App\Controller;

use App\Entity\Owner;
use App\Form\OwnerType;
use App\Repository\OwnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/owner")
 */
class OwnerController extends AbstractController
{
    /**
     * @Route("/list", name="owner_index", methods={"GET"})
     */
    public function index(OwnerRepository $ownerRepository): Response
    {
        return $this->render('owner/index.html.twig', [
            'owners' => $ownerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="owner_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $owner = new Owner();
        $form = $this->createForm(OwnerType::class, $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($owner);
            $entityManager->flush();

            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'Owner added');

            return $this->redirectToRoute('owner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('owner/new.html.twig', [
            'owner' => $owner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="owner_show", methods={"GET"})
     */
    public function show(Owner $owner): Response
    {
        return $this->render('owner/show.html.twig', [
            'owner' => $owner,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="owner_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Owner $owner): Response
    {
        $form = $this->createForm(OwnerType::class, $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'Owner modified');

            return $this->redirectToRoute('owner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('owner/edit.html.twig', [
            'owner' => $owner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="owner_delete", methods={"POST"})
     */
    public function delete(Request $request, Owner $owner): Response
    {
        if ($this->isCsrfTokenValid('delete' . $owner->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($owner);
            $entityManager->flush();
        }

        // Make sure message will be displayed after redirect
        $this->get('session')->getFlashBag()->add('message', 'Owner deleted');

        return $this->redirectToRoute('owner_index', [], Response::HTTP_SEE_OTHER);
    }
}
