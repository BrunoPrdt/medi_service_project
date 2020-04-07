<?php

namespace App\Controller;

use App\Entity\Prospects;
use App\Form\ProspectsType;
use App\Repository\ProspectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/prospects")
 */
class ProspectsController extends AbstractController
{
    /**
     * @Route("/", name="prospects_index", methods={"GET"})
     * @param ProspectsRepository $prospectsRepository
     * @return Response
     */
    public function index(ProspectsRepository $prospectsRepository): Response
    {
        return $this->render('admin/prospects/index.html.twig', [
            'prospects' => $prospectsRepository->findAll(),
            'current_menu' => 'prospects_active',
        ]);
    }

    /**
     * @Route("/new", name="prospects_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $prospect = new Prospects();
        $form = $this->createForm(ProspectsType::class, $prospect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //$entityManager->persist($prospect);
            //$entityManager->flush();

            return $this->redirectToRoute('prospects_index');
        }

        return $this->render('admin/prospects/new.html.twig', [
            'prospect' => $prospect,
            'form' => $form->createView(),
            'current_menu' => 'prospects_active',
        ]);
    }

    /**
     * @Route("/{id}", name="prospects_show", methods={"GET"})
     * @param Prospects $prospect
     * @return Response
     */
    public function show(Prospects $prospect): Response
    {
        return $this->render('admin/prospects/show.html.twig', [
            'prospect' => $prospect,
            'current_menu' => 'prospects_active',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="prospects_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Prospects $prospect
     * @return Response
     */
    public function edit(Request $request, Prospects $prospect): Response
    {
        $form = $this->createForm(ProspectsType::class, $prospect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prospects_index');
        }

        return $this->render('admin/prospects/edit.html.twig', [
            'prospect' => $prospect,
            'form' => $form->createView(),
            'current_menu' => 'prospects_active',
        ]);
    }

    /**
     * @Route("/{id}", name="prospects_delete", methods={"DELETE"})
     * @param Request $request
     * @param Prospects $prospect
     * @return Response
     */
    public function delete(Request $request, Prospects $prospect): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prospect->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            //$entityManager->remove($prospect);
            //$entityManager->flush();
        }

        return $this->redirectToRoute('prospects_index');
    }
}
