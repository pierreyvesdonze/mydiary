<?php

namespace App\Form;

use App\Entity\Quote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text', TextareaType::class, [
                'label' => 'Écrivez votre citation (180 caractères max)',
                'attr'  => [
                    'maxLength' => 180
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Vérifier",
                'attr' => [
                    'class' => "custom-btn validate-btn"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quote::class,
        ]);
    }
}
