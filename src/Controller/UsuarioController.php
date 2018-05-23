<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/usuario")
 */
class UsuarioController extends Controller
{
    /**
     * @Route("/", name="usuario_index", methods="GET")
     */
    public function index(UsuarioRepository $usuarioRepository): Response
    {
        return $this->render('usuario/index.html.twig', ['usuarios' => $usuarioRepository->findAll()]);
    }
    /**
     * @Route("/new", name="usuario_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $encoder = $this->get('security.password_encoder');
            $pass = $encoder->encodePassword($usuario, $usuario->getPassword());
            $usuario->setPassword($pass);
            $em->persist($usuario);
            $em->flush();

            $this->addFlash('success', "Usuário foi salvo com sucesso!");
            return $this->redirectToRoute('usuario_index');
        }
        return $this->render('usuario/new.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="usuario_show", methods="GET")
     */
    public function show(Usuario $usuario): Response
    {
        return $this->render('usuario/show.html.twig', ['usuario' => $usuario]);
    }
    /**
     * @Route("/{id}/edit", name="usuario_edit", methods="GET|POST")
     */
    public function edit(Request $request, Usuario $usuario): Response
    {
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $encoder = $this->get('security.password_encoder');
            $pass = $encoder->encodePassword($usuario, $usuario->getPassword());
            $usuario->setPassword($pass);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "Usuário foi editado com sucesso!");
            return $this->redirectToRoute('usuario_index', ['id' => $usuario->getId()]);
        }
        return $this->render('usuario/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="usuario_delete", methods="DELETE")
     */
    public function delete(Request $request, Usuario $usuario): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usuario->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usuario);
            $em->flush();
        }

        $this->addFlash('success', "Usuário foi removido com sucesso!");
        return $this->redirectToRoute('usuario_index');
    }
}
