<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Module;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez le titre du cours',
                    'class' => 'form-control form-control-user',
                ],
            ])
            ->add('code', TextType::class, [
                'attr' => [
                    'placeholder' => '(ex : "MATH101-M1")',
                    'class' => 'form-control form-control-user',
                ],
            ])
            ->add('durre', NumberType::class, [
                'label' => 'Durée',
                'attr' => [
                    'placeholder' => 'Entrez la durée du cours',
                    'class' => 'form-control form-control-user',
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Entrez la description du cours',
                    'class' => 'form-control form-control-user',
                ],
            ])
            ->add('videoFile', FileType::class, [
                'label' => 'Fichier vidéo (mp4, avi, etc.)',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '100M', // Taille maximale du fichier
                        'mimeTypes' => [
                            'video/mp4',
                            'video/x-msvideo', // AVI
                            'video/mpeg',
                            'video/quicktime', // MOV
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier vidéo valide (mp4, avi, mpeg, mov).',
                    ]),
                ],
                'attr' => [
                    'accept' => 'video/*', // Permet de filtrer les fichiers vidéo dans le sélecteur de fichiers
                    'class' => 'form-control form-control-user',
                ],
            ])
            ->add('module', EntityType::class, [
                'class' => Module::class,
                'choice_label' => 'titre',
                'attr' => [
                    'class' => 'form-control form-control-user',
                ],
            ])
            ->add('createdAt', DateType::class, [
                'input' => 'datetime_immutable',
                'attr' => [
                    'class' => 'form-control form-control-user',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
