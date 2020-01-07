<?php

namespace App\Controller;

use App\Entity\Biblioteca;
use App\Entity\Prestamo;
use App\Form\PrestamoType;
use App\Repository\PrestamoRepository;
use App\Entity\Persona;
use App\Entity\Material;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/prestamo")
 */
class PrestamoController extends AbstractController
{
    /**
     * @Route("/llevar", name="prestamo_llevar", methods={"POST"})
     */
    public function llevar(Request $request)
    {
        //personaID, materialID, biblioteca.
        $data = $request->request->all();
        $entityManager = $this->getDoctrine()->getManager();

        $biblioteca = $entityManager->getRepository(Biblioteca::class)->find($data['biblioteca']);

        $prestamoId = $entityManager->getRepository(Prestamo::class)->findBy(array(), array('prestamo'=>'desc'));
        ($prestamoId)? $prestamoId = $prestamoId['0']->getPrestamo()+1:$prestamoId=1;
        $persona = $entityManager->getRepository(Persona::class)->find($data['personaId']);

        if($persona->getLibros() > 0){
            return new JsonResponse(['status'=>Response::HTTP_NOT_FOUND, 'mensaje'=>'Esta persona tiene un prestamo pendiente']);
        }

        foreach($data['materialId'] as $material){
            $mater = $entityManager->getRepository(Material::class)->find($material);
            if($mater->getStatus() == 'Ocupado'){
                return new JsonResponse(['status'=>Response::HTTP_NOT_FOUND, 'mensaje'=>'Alguno de los libros se encuentran ocupados']);
            }
        }

        $adeudo = 0;
        $libros = 0;
        foreach($data['materialId'] as $material){
            $prestamo = new Prestamo();
            $mater = $entityManager->getRepository(Material::class)->find($material);
            $adeudo += $mater->getPrecio();
            $prestamo->setPrestamo($prestamoId);
            $prestamo->setBiblioteca($biblioteca);
            $prestamo->setEntregado(0);
            $entityManager->persist($prestamo);
            $entityManager->flush();
            $mater->setStatus('Ocupado');
            $mater->setPrestamo($prestamo);
            $libros++;
        }
        $persona->setPrestamo($prestamoId);
        $persona->setAdeudo($adeudo);
        $persona->setLibros($libros);
        $entityManager->persist($persona);
        $entityManager->flush();

        return $this->redirectToRoute('prestamo_index');
    }
    /**
     * @Route("/dejar", name="prestamo_dejar", methods={"POST"})
     */
    public function dejar(Request $request)
    {
        //personaID
        $data = $request->get('id');
        $entityManager = $this->getDoctrine()->getManager();

        $persona = $entityManager->getRepository(Persona::class)->find($data);
        $prestamos = $persona->getPrestamo();
        if(is_null($prestamos) || $prestamos == 0){
            return new JsonResponse(['status'=>Response::HTTP_NOT_FOUND, 'mensaje'=>'Esta persona no tiene prestamos pendientes']);
        }
        $prestamos = $entityManager->getRepository(Prestamo::class)->findBy(['prestamo'=>$prestamos]);
        foreach($prestamos as $p){
            $p->setEntregado(1);
            $material = $entityManager->getRepository(Material::class)->findOneBy(['prestamo'=>$p->getId()]);
            $material->setStatus('Disponible');
            $material->setPrestamo(NULL);
            $entityManager->persist($material);
            //$entityManager->flush();
            $entityManager->persist($p);
            //$entityManager->flush();
        }
        $persona->setAdeudo(0);
        $persona->setLibros(0);
        $persona->setPrestamo(0);
        $entityManager->persist($persona);
        try {
            $entityManager->flush();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            exit();
        }
        return new JsonResponse(['status'=>Response::HTTP_OK, 'mensaje'=>'Los libros han sido entregados']);

    }




    /**
     * @Route("/", name="prestamo_index", methods={"GET"})
     */
    public function index(PrestamoRepository $prestamoRepository): Response
    {
        $prestamo = $prestamoRepository->findAll();
        $prestamoArr = $prestamoRepository->allToArray($prestamo);
        return new JsonResponse($prestamoArr);
    }

    /**
     * @Route("/new", name="prestamo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $prestamo = new Prestamo();
        $form = $this->createForm(PrestamoType::class, $prestamo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prestamo);
            $entityManager->flush();

            return $this->redirectToRoute('prestamo_index');
        }

        return $this->render('prestamo/new.html.twig', [
            'prestamo' => $prestamo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prestamo_show", methods={"GET"})
     */
    public function show(Prestamo $prestamo): Response
    {
        return $this->render('prestamo/show.html.twig', [
            'prestamo' => $prestamo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="prestamo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Prestamo $prestamo): Response
    {
        $form = $this->createForm(PrestamoType::class, $prestamo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prestamo_index');
        }

        return $this->render('prestamo/edit.html.twig', [
            'prestamo' => $prestamo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prestamo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Prestamo $prestamo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prestamo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($prestamo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('prestamo_index');
    }
}
