<?php

namespace App\Controller;

use App\Enum\FuncionarioStatusEnum;
use App\Repository\FuncionarioRepository;
use PHPExcel;
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
           ->add('excel', SubmitType::class, [
               'label' => 'Gerar Excel'
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

           $excelClicked = $form->get('excel')->isClicked();

           if ($excelClicked) {
               return $this->funcionarioExcel($funcionarios);
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

    /**
     * @Route("/relatorio/secretaria_excel", name="secretaria_excel")
     */
    public function secretariaExcel(Request $request, FuncionarioRepository $funcionarioRepository)
    {

        $excel = new PHPExcel();

        $total = $funcionarioRepository->salarioTotal();

        $excel->setActiveSheetIndex(0)
            ->setCellValue('A1','Total de Salários')
            ->setCellValue( 'B1', 'Secretaria');

        $contador = 1;

        foreach ($total as $linha) {
            $contador++;
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$contador, $linha['total']);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$contador, $linha['nome']);
        }

        header('Content-Type: application/vnd.openxmlformarts-officedocument.spreadsheetml.sheet ');
        header('Content-Disposition: attachment; filename="test.xlsx"');
        header('Cache-Control: max-age=0');

        $file = \PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $file->save('php://output');
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

    /**
     * @Route("/relatorio/funcionario_excel", name="funcionario_excel")
     */
    public function funcionarioExcel($funcionarios)
    {
        $excel = new PHPExcel();

        $total = $funcionarios;

        $excel->setActiveSheetIndex(0)
            ->setCellValue('A1','Mat.')
            ->setCellValue( 'B1', 'Nome')
            ->setCellValue( 'C1', 'Cargo')
            ->setCellValue( 'D1', 'Status')
            ->setCellValue( 'E1', 'Data Admissão')
            ->setCellValue( 'F1', 'Data Exoneração')
            ->setCellValue( 'G1', 'Salário Liquído');

        $contador = 1;
        foreach ($total as $linha) {
            $contador++;
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$contador, $linha->getId());
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$contador, $linha->getNome());
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$contador, $linha->getCargo());
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$contador, $linha->getStatus());
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$contador, $linha->getDataAdmissao());
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$contador, $linha->getDataExoneracao());
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$contador, $linha->getSalarioLiquido());
        }

        header('Content-Type: application/vnd.openxmlformarts-officedocument.spreadsheetml.sheet ');
        header('Content-Disposition: attachment; filename="test.xlsx"');
        header('Cache-Control: max-age=0');

        $file = \PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $file->save('php://output');
    }
}
