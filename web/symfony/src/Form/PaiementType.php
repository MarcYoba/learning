<?php

namespace App\Form;

use App\Entity\Paiement;
use App\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant',IntegerType::class,[
                'label' => 'Montant',
                'attr' => ['class' => 'form-control form-control-user'],
            ])
            ->add('operateur', ChoiceType::class, [
                'choices' => [
                    'Orange Money' => 'orange_money',
                    'Mobile Money' => 'mobile_money',
                ],
                'label' => 'Opérateur',
                'attr' => ['class' => 'form-control form-control-user'],
            ])
            ->add('numerobancaire', IntegerType::class, [
                'label' => 'Numéro de carte',
                'attr' => [
                    'class' => 'form-control form-control-user',
                    'placeholder' => '1234 5678 9012 3456',
                ],
            ])
            ->add('nomtitulaire',TextType::class, [
                'label' => 'Nom du titulaire',
                'attr' => [
                    'class' => 'form-control form-control-user',
                    'placeholder' => 'Nom du titulaire',
                ],
            ])
            ->add('CVV',IntegerType::class, [
                'label' => 'CVV',
                'attr' => [
                    'class' => 'form-control form-control-user',
                    'placeholder' => '123',
                ],
            ])
            ->add('dateExpiration', DateType::class, [
                'input' => 'datetime_immutable',
                'label' => 'Date d\'expiration',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control form-control-user',
                    'placeholder' => 'JJ/MM/AAAA',
                ],
                'required' => false,
            ])
            ->add('telephone',TelType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'class' => 'form-control form-control-user',
                    'placeholder' => '+33 6 12 34 56 78',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}
