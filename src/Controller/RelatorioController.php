<?php

namespace App\Controller;

use App\Enum\FuncionarioStatusEnum;
use App\Repository\FuncionarioRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dompdf\Dompdf;

require __DIR__ . '/../../vendor/autoload.php';

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
     * @Route("/relatorio/secretaria",name="relatorio_secretaria")
     * @Template("relatorio/secretaria.html.twig")
     * @return Response
     */
    public function relatorioSecretaria(Request $request, FuncionarioRepository $funcionarioRepository)
    {
        return $this->render(
            'relatorio/secretaria.html.twig',
            ['totalSalarios' => $funcionarioRepository->salarioTotal()]
        );
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
           ->add('pdf', SubmitType::class, [
               'label' => 'Gerar PDF'
           ])
           ->add('pesquisar', SubmitType::class, [
               'label' => 'Pesquisar'
           ])
           ->getForm();

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
           $data = $form->getData();
           $funcionarios = $funcionarioRepository->getFuncionarioAtivoPorData(
               $data['data_inicio'],
               $data['data_fim'],
               $data['status']
           );

           $pdfClicked = $form->get('pdf')->isClicked();

           if ($pdfClicked) {
               return $this->funcionarioPdf($funcionarios);
           }
       }

       return $this->render('relatorio/funcionario.html.twig', [
           'funcionarios' => $funcionarios,
           'form' => $form->createView()

       ]);
   }

    /**
     * @Route("/relatorio/secretaria_pdf", name="secretaria_pdf")
     */
    public function secretariaPdf(Request $request, FuncionarioRepository $funcionarioRepository)
    {
           $view = $this->renderView(
            'relatorio/secretaria_pdf.html.twig',
            ['totalSalarios' => $funcionarioRepository->salarioTotal()]
        );


        $domPdf = new Dompdf();

        $domPdf->loadHtml($view);

        $domPdf->setPaper('A4','portrait');
        $domPdf->render();

        return $domPdf->stream();
    }

    private function funcionarioPdf($funcionarios)
    {
        $view = $this->renderView('relatorio/funcionario_pdf.html.twig', [
           'funcionarios' =>  $funcionarios
        ]);

        $domPdf = new Dompdf();
        $domPdf->loadHtml($view);
        $domPdf->setPaper('A4','portrait');
        $domPdf->render();

        return $domPdf->stream();
    }
}
