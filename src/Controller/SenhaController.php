<?php

namespace App\Controller;

use App\Form\SenhaType;
use App\Repository\UsuarioRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/senha")
 */
class SenhaController extends Controller
{
    /**
     * @Route("/edit", name="senha_edit", methods="GET|POST")
     */
    public function edit(Request $request, UsuarioRepository $usuarioRepository)
    {
        $usuario = $this->getUser();
        $usuarioDb = $usuarioRepository->find($usuario->getId());
        $senha = $usuarioDb->getPassword();
        $form = $this->createForm(SenhaType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (null != $usuario->getPassword()) {
                $encoder = $this->container->get('security.password_encoder');
                $password = $encoder->encodePassword($usuario, $usuario->getPassword());
                $usuario->setPassword($password);
            }else{
                $usuario->setPassword($senha);
            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Sua senha foi alterada com sucesso!');
            return $this->redirectToRoute('senha_edit');
        }
        return $this->render('senha/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView()
        ]);
    }
}