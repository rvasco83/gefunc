<?php

namespace App\Controller;

use App\Enum\FuncionarioStatusEnum;
use App\Repository\FuncionarioRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RelatorioController extends Controller
{
    /**
     * @Route("/relatorio", name="relatorio_index")
     * @Template("relatorio/index.html.twig")
     */
    public function index()
    {
        return $this->render('relatorio/index.html.twig', [
            'controller_name' => 'RelatorioController',
        ]);
    }

    /**
     * @param Request $request
     *
     * @Route("/relatorio/secretaria", name="relatorio_secretaria")
     * @Template("relatorio/secretaria.html.twig")
     * @return Response
     */
    public function relatorioSecretaria(FuncionarioRepository $funcionarioRepository)
    {
        return $this->render('relatorio/secretaria.html.twig', ['totalSalarios' => $funcionarioRepository->salarioTotal()]);
    }

   /**
    * @param Request $request
    *
    * @Route("/relatorio/funcionario", name="relatorio_funcionario")
    * @Template("relatorio/funcionario.html.twig")
    * @return Response
    */
   public function relatorioFuncionario(Request $request, FuncionarioRepository $funcionarioRepository)
   {
       $funcionarios = [];
       $form = $this->createFormBuilder()
           ->add('data_inicio', DateType::class, [
               'widget' => 'single_text'
           ])
           ->add('data_fim', DateType::class, [
               'widget' => 'single_text'
           ])
           ->add('status', ChoiceType::class, [
               'choices' => array_flip(FuncionarioStatusEnum::getStatus())
           ])
           ->getForm();

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
           // data is an array with "name", "email", and "message" keys
           $data = $form->getData();

           $funcionarios = $funcionarioRepository->getFuncionarioAtivoPorData($data['data_inicio'], $data['data_fim'], $data['status']);

       }
       return $this->render('relatorio/funcionario.html.twig', [
           'funcionarios' => $funcionarios,
           'form' => $form->createView()
       ]);
   }
}
