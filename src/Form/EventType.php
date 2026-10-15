<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, ['label' => 'Titre'])
            ->add('date', null, ['label' => 'Date']) 
            ->add('informations', null, ['label' => 'Informations']) 
            ->add('category', null, ['label' => 'Catégorie'])
            ->add('nombreDePlaces', null, ['label' => 'Nombre de places'])
            ->add('imageFile', FileType::class, [
                'label' => 'Image (JPG, PNG, WebP)',
                'mapped' => false, // Le champ n'est pas lié directement à l'entité
                'required' => false, // L'image reste facultative
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPG, PNG ou WebP).',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}