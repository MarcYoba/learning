<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'attr' => ['class' => "form-control form-control-user"]
            ])
            ->add('prix',IntegerType::class,[
                'attr' => ['class' => "form-control form-control-user"]
            ])
            ->add('quantite',IntegerType::class,[
                'attr' => ['class' => "form-control form-control-user"]
            ])
            ->add('caracteristique',TextareaType::class,[
                'attr' => ['class' => "form-control form-control-user"]
            ])
            ->add('description',TextareaType::class,[
                'attr' => ['class' => "form-control form-control-user"]
            ])
            ->add('reduction',IntegerType::class,[
                'attr' => ['class' => "form-control form-control-user"]
            ])
            ->add('createAd', DateType::class,[
                'input' => 'datetime_immutable',
                'attr' => ['class' => "form-control form-control-user"]
            ])
            ->add('image',FileType::class,[
                'mapped' => false,
                'attr' => ['class' => "form-control form-control-user"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
