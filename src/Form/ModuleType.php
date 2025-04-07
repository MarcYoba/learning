<?php

namespace App\Form;

use App\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt' , DateType::class,[
                'input' => 'datetime_immutable',
                'attr' => [
                    'class' => 'form-control form-control-user',
                ],
            ])
            ->add('titre', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez le titre du module',
                    'class' => 'form-control form-control-user',
                ],
            ])
            ->add('code', TextType::class, [
                
                'attr' => [
                    'placeholder' => '(ex : "MATH101-M1")',
                    'class' => 'form-control form-control-user',
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Entrez la description du module',
                    'class' => 'form-control form-control-user',
                ],
            ])
            ->add('duree', NumberType::class, [
                'label' => 'Durée',
                'attr' => [
                    'placeholder' => 'Entrez la durée du module',
                    'class' => 'form-control form-control-user',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
