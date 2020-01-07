<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Form\PersonaType;
use App\Repository\PersonaRepository;
use App\Entity\Biblioteca;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class PersonaController extends AbstractController
{
    /**
     * @Route("/persona", name="persona_index", methods={"GET"})
     */
    public function index(PersonaRepository $personaRepository): Response
    {
        $personas = $personaRepository->findAll();
        $personasArr = $personaRepository->allToArray($personas);
        return new JsonResponse($personasArr);
    }

    /**
     * @Route("/persona/new", name="persona_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $data = $request->request->all();
        $entityManager = $this->getDoctrine()->getManager();
        $persona = new Persona();

        $biblioteca = $entityManager->getRepository(Biblioteca::class)->find($data['biblioteca']);

        $persona->setNombre($data['nombre']);
        $persona->setApellido($data['apellido']);
        $persona->setCorreo($data['correo']);
        $persona->setTelefono($data['telefono']);
        $persona->setNumPersona($data['numPersona']);
        $persona->setBiblioteca($biblioteca);
        $persona->setTipo($data['tipo']);
        $persona->setLibros(0);
        $persona->setAdeudo(0);
        $entityManager->persist($persona);
        $entityManager->flush();

        return $this->redirectToRoute('persona_index');
    }

    /**
     * @Route("/persona/{id}", name="persona_show", methods={"GET"})
     */
    public function show(Persona $persona): Response
    {
        $m = [
            'id' => $persona->getId(),
            'nombre' => $persona->getNombre(),
            'apellido' => $persona->getApellido(),
            'correo' => $persona->getCorreo(),
            'telefono' => $persona->getTelefono(),
            'libros' => $persona->getLibros(),
            'adeudo' => $persona->getAdeudo(),
            'matricula' => $persona->getNumPersona(),
            'biblioteca' => $persona->getBiblioteca()->getNombre(),
        ];
        return new JsonResponse($m);
    }

    /**
     * @Route("/persona/{id}/edit", name="persona_edit", methods={"GET","POST"})
     */

    public function edit(Request $request, Persona $persona): Response
    {
        $form = $this->createForm(PersonaType::class, $persona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('persona_index');
        }

        return $this->render('persona/edit.html.twig', [
            'persona' => $persona,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="persona_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Persona $persona): Response
    {
        if ($this->isCsrfTokenValid('delete'.$persona->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($persona);
            $entityManager->flush();
        }

        return $this->redirectToRoute('persona_index');
    }
}
