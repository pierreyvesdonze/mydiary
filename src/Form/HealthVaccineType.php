<?php

namespace App\Form;

use App\Entity\Vaccine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HealthVaccineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom de votre vaccin'
            ])
            ->add('injectionDate', null, [
                'required' => false,
                'label'    => "Date d'injection du vaccin",
                'widget'   => 'single_text'
            ])
            ->add('deadlineDate', null, [
                'label'  => 'Date de rappel',
                'widget' => 'single_text'
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Valider",
                'attr' => [
                    'class' => "custom-btn validate-btn"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vaccine::class,
        ]);
    }
}
