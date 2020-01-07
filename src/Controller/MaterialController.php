<?php

namespace App\Controller;

use App\Entity\Biblioteca;
use App\Entity\Material;
use App\Form\MaterialType;
use App\Repository\MaterialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/material")
 */
class MaterialController extends AbstractController
{
    /**
     * @Route("/", name="material_index", methods={"GET"})
     */
    public function index(MaterialRepository $materialRepository): Response
    {
        $materiales = $materialRepository->findAll();
        $materialArr = $materialRepository->allToArray($materiales);
        return new JsonResponse($materialArr);
    }

    /**
     * @Route("/new", name="material_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $data = $request->request->all();
        $entityManager = $this->getDoctrine()->getManager();
        $material = new Material();

        $biblioteca = $entityManager->getRepository(Biblioteca::class)->find($data['biblioteca']);

        $material->setTipo($data['tipo']);
        $material->setCodigo($data['codigo']);
        $material->setAutor($data['autor']);
        $material->setTitulo($data['titulo']);
        $material->setAnio($data['anio']);
        $material->setBiblioteca($biblioteca);
        (array_key_exists('editorial', $data))? $material->setEditorial($data['editorial']) : $material->setEditorial("");

        $material->setPrecio($data['precio']);
        $material->setStatus('Disponible');
        $entityManager->persist($material);
        $entityManager->flush();

        return $this->redirectToRoute('material_index');
    }

    /**
     * @Route("/{id}", name="material_show", methods={"GET"})
     */
    public function show(Material $material): Response
    {
        return $this->render('material/show.html.twig', [
            'material' => $material,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="material_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Material $material): Response
    {
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('material_index');
        }

        return $this->render('material/edit.html.twig', [
            'material' => $material,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="material_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Material $material): Response
    {
        if ($this->isCsrfTokenValid('delete'.$material->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($material);
            $entityManager->flush();
        }

        return $this->redirectToRoute('material_index');
    }
}
