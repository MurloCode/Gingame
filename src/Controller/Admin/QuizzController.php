<?php

namespace App\Controller\Admin;

use App\Entity\Quizz;
use App\Form\Quizz1Type;
use App\Repository\HistoricRepository;
use App\Repository\QuizzRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @isGranted("ROLE_ADMIN") 
 * @Route("/admin/quizz")
 */
class QuizzController extends AbstractController
{
    /**
     * @Route("/", name="admin_quizz_index", methods={"GET"})
     */
    public function index(QuizzRepository $quizzRepository): Response
    {
        return $this->render('admin/quizz/index.html.twig', [
            'quizzs' => $quizzRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_quizz_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $quizz = new Quizz();
        $form = $this->createForm(Quizz1Type::class, $quizz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quizz);
            $entityManager->flush();

            return $this->redirectToRoute('admin_quizz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/quizz/new.html.twig', [
            'quizz' => $quizz,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_quizz_show", methods={"GET"})
     */
    public function show(Quizz $quizz): Response
    {
        return $this->render('admin/quizz/show.html.twig', [
            'quizz' => $quizz,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_quizz_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quizz $quizz): Response
    {
        $form = $this->createForm(Quizz1Type::class, $quizz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_quizz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/quizz/edit.html.twig', [
            'quizz' => $quizz,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_quizz_delete", methods={"POST"})
     */
    public function delete(Request $request, Quizz $quizz, HistoricRepository $historicRepository, int $id): Response
    {
        $historic = $historicRepository->findBy(['quizz' => $id]);
        foreach ($historic as $key => $historic) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($historic);
        };

        if ($this->isCsrfTokenValid('delete'.$quizz->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quizz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_quizz_index', [], Response::HTTP_SEE_OTHER);
    }
}
