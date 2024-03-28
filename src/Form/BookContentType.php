<?php

namespace App\Form;

use App\Entity\BookContent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class BookContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', CKEditorType::class, [
                'label' => 'Contenu',
                'attr' => [
                    'class' => 'large-input'
                ],
                'config_name' => 'my_config'
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Valider",
                'attr' => [
                    'class' => "custom-btn validate-btn"
                ]
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookContent::class,
        ]);
    }
}
