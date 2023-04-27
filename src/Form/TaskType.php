<?php 

namespace App\Form;

use Symfony\Component\DomCrawler\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class TaskType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', TextType::class, array(
                    'label' => 'Título'
                ))
                ->add('content', TextareaType::class, array(
                    'label' => 'Contenido'
                ))
                ->add('priority', ChoiceType::class, array(
                    'label' => 'Prioridad',
                    'choices' => [
                        'Alta' => 'high',
                        'Media' => 'medium',
                        'Baja' => 'low',
                    ]
                ))
                ->add('hours', NumberType::class, array(
                    'label' => 'Horas presupuestadas'
                ))
                ->add('submit', SubmitType::class, array(
                    'label' => 'Enviar'
                ));
    }
}