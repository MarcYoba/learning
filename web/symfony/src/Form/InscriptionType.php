<?php

namespace App\Form;

use App\Entity\Inscription;
use App\Entity\Module;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => 'Nom',
                'attr' => ['class' => 'form-control form-control-user'],
            ])
            ->add('module',EntityType::class, [
                'class' => Module::class,
                'choice_label' => 'titre',
                'attr' => ['class' => 'form-control form-control-user'],
            ])
            // ->add('status', TextType::class, [
            //     'label' => 'Status',
            //     'attr' => ['class' => 'form-control form-control-user'],
            // ])
            ->add('createdAt', DateType::class, [
                'label' => 'Date d\'inscription',
                'input' => 'datetime_immutable',
                'attr' => ['class' => 'form-control form-control-user'],
            ])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
