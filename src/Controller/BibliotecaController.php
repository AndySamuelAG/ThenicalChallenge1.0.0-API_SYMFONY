<?php

namespace App\Controller;

use App\Entity\Biblioteca;
use App\Form\BibliotecaType;
use App\Repository\BibliotecaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PersonaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/biblioteca")
 */
class BibliotecaController extends AbstractController
{
    /**
     * @Route("/", name="biblioteca_index", methods={"GET"})
     */
    public function index(BibliotecaRepository $bibliotecaRepository)
    {
        $bibliotecas = $bibliotecaRepository->findAll();
        $bibliotecaArr = $bibliotecaRepository->allToArray($bibliotecas);
        return new JsonResponse($bibliotecaArr);
    }

    /**
     * @Route("/new", name="biblioteca_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $data = $request->request->all();

        $entityManager = $this->getDoctrine()->getManager();
        $biblioteca = new Biblioteca;
        $biblioteca->setNombre($data['nombre']);
        $entityManager->persist($biblioteca);
        $entityManager->flush();
        return $this->redirectToRoute('biblioteca_index');
    }

    /**
     * @Route("/{id}", name="biblioteca_show", methods={"GET"})
     */
    public function show(Biblioteca $biblioteca): Response
    {
        $m = [
            'id' => $biblioteca->getId(),
            'nombre' => $biblioteca->getNombre(),
        ];
        return new JsonResponse($m);
    }

    /**
     * @Route("/{id}/persona", name="biblioteca_persona", methods={"GET"})
     */
    public function indexBiblioteca(Request $request, PersonaRepository $personaRepository): Response
    {
        $id = $request->get('id');
        $personas = $personaRepository->findBy(['biblioteca'=> $id]);
        $personasArr = $personaRepository->allToArray($personas);
        return new JsonResponse($personasArr);
    }

    /**
     * @Route("/{id}/edit", name="biblioteca_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Biblioteca $biblioteca): Response
    {
        $form = $this->createForm(BibliotecaType::class, $biblioteca);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('biblioteca_index');
        }

        return $this->render('biblioteca/edit.html.twig', [
            'biblioteca' => $biblioteca,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="biblioteca_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Biblioteca $biblioteca): Response
    {
        if ($this->isCsrfTokenValid('delete'.$biblioteca->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($biblioteca);
            $entityManager->flush();
        }

        return $this->redirectToRoute('biblioteca_index');
    }
}
