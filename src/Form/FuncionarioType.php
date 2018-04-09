<?php

namespace App\Form;

use App\Entity\Funcionario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FuncionarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class,[
                'label' => 'Nome',
                'attr' => [
                    'placeholder' => 'Informe o nome do funcionário'
                ]
            ])
            ->add('logadouro', TextType::class,[
                'label' => 'Logadouro',
                'attr' => [
                    'placeholder' => 'Informe o logadouro do funcionário'
                ]
            ])
            ->add('numero', TextType::class,[
                'label' => 'Número',
                'attr' => [
                    'placeholder' => 'Informe o número do logadouro do funcionário'
                ]
            ])
            ->add('bairro', TextType::class,[
                'label' => 'Bairro',
                'attr' => [
                    'placeholder' => 'Informe o bairro do funcionário'
                ]
            ])
            ->add('cidade', TextType::class,[
                'label' => 'Cidade',
                'attr' => [
                    'placeholder' => 'Informe a cidade do funcionário'
                ]
            ])
            ->add('estado', TextType::class,[
                'label' => 'Estado',
                'attr' => [
                    'placeholder' => 'Informe o estado do funcionário'
                ]
            ])
            ->add('identidade', NumberType::class,[
                'label' => 'Identidade',
                'attr' => [
                    'placeholder' => 'Informe a identidade do funcionário'
                ]
            ])

            ->add('imagem_documento', FileType::class, [
                'label' => 'Selecione a imagem da identidade'
            ])

            ->add('cargo', ChoiceType::class, [
                'label' => 'Cargo',
                'choices' => [
                    'Efetivo' => 'E',
                    'Comissionado' => 'C'
                ]
            ])
            ->add('data_admissao', DateType::class, [
                'widget' => 'choice',
                'format' => 'dd/MM/yyyy'
            ])

            ->add('salario_base', MoneyType::class, [
                'label' => 'Salário Base  ',
                'currency' => 'BRL',
                'attr' => [
                    'placeholder' => 'Informe o salário base do funcionário'
                ]
            ])
            ->add('gratificacao', MoneyType::class, [
                'label' => 'Gratificação  ',
                'currency' => 'BRL',
                'attr' => [
                    'placeholder' => 'Informe a gratificacao do funcionário'
                ]
            ])
            ->add('desconto', MoneyType::class, [
                'label' => 'Desconto  ',
                'currency' => 'BRL',
                'attr' => [
                    'placeholder' => 'Informe o desconto do funcionário'
                ]
            ])
            ->add('Secretaria', EntityType::class, [
                'class' => 'App\Entity\Secretaria',
                'choice_label' => 'nome',
                'multiple' => false,
            ])
            ->add('enviar', SubmitType::class, [
                'label' => "Salvar",
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $funcionario = $event->getData();
            $form = $event->getForm();
            if ($funcionario->getId() != null) {
                $form->add('status', ChoiceType::class, [
                    'label' => 'Status',
                    'choices' => [
                        'Ativo' => 'A',
                        'Exonerado' => 'E'
                    ]
                ])

                ->add('imagem_documento', FileType::class, [
                    'label' => 'Selecione a imagem da identidade',
                    'required' => false
                ]);
                $estadoDataExoneracao = true;
                if($funcionario->getStatus() == 'E') {
                    $estadoDataExoneracao = false;
                }
                $form ->add('data_exoneracao', DateType::class, [
                    'widget' => 'choice',
                    'format' => 'dd/MM/yyyy',
                    'disabled' => $estadoDataExoneracao
                ]);
                $estadoGratificacao = false;
                if($funcionario->getCargo() == 'C') {
                    $estadoGratificacao = true;
                }
                $form ->add('gratificacao', MoneyType::class, [
                    'label' => 'Gratificação  ',
                    'currency' => 'BRL',
                    'attr' => [
                        'placeholder' => 'Informe a gratificacao do funcionário',
                        'disabled' => $estadoGratificacao
                    ]

                ]);
            }
        });

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Funcionario::class,
        ]);
    }
}
