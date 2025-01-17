<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Technology;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title')
        ->add('description')
        ->add('createdAt')
        ->add('screenshot', FileType::class, [
            'label' => 'Capture d\'écran (image JPG ou PNG)',
            'mapped' => false, // Ne lie pas directement au champ de l'entité
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '2M',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Veuillez uploader une image valide (JPG ou PNG).',
                ]),
            ],
        ])
        ->add('technologies', EntityType::class, [
            'class' => Technology::class,
            'choice_label' => 'name', // Affiche le nom de la technologie dans le select
            'multiple' => true, // Permet la sélection multiple
            'expanded' => true, // Change le select en checkbox (facultatif)
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
