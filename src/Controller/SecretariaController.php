<?php

namespace App\Controller;

use App\Entity\Secretaria;
use App\Form\SecretariaType;
use App\Repository\SecretariaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/secretaria")
 */
class SecretariaController extends Controller
{
    /**
     * @Route("/", name="secretaria_index", methods="GET")
     */
    public function index(SecretariaRepository $secretariaRepository): Response
    {
        return $this->render('secretaria/index.html.twig', ['secretarias' => $secretariaRepository->findAll()]);
    }
    /**
     * @Route("/new", name="secretaria_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $secretarium = new Secretaria();
        $form = $this->createForm(SecretariaType::class, $secretarium);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($secretarium);
            $em->flush();
            return $this->redirectToRoute('secretaria_index');
        }
        return $this->render('secretaria/new.html.twig', [
            'secretarium' => $secretarium,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="secretaria_show", methods="GET")
     */
    public function show(Secretaria $secretarium): Response
    {
        return $this->render('secretaria/show.html.twig', ['secretarium' => $secretarium]);
    }
    /**
     * @Route("/{id}/edit", name="secretaria_edit", methods="GET|POST")
     */
    public function edit(Request $request, Secretaria $secretarium): Response
    {
        $form = $this->createForm(SecretariaType::class, $secretarium);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('secretaria_edit', ['id' => $secretarium->getId()]);
        }
        return $this->render('secretaria/edit.html.twig', [
            'secretarium' => $secretarium,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="secretaria_delete", methods="DELETE")
     */
    public function delete(Request $request, Secretaria $secretarium): Response
    {
        if ($this->isCsrfTokenValid('delete'.$secretarium->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($secretarium);
            $em->flush();
        }
        return $this->redirectToRoute('secretaria_index');
    }
}