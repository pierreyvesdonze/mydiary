<?php

namespace App\Form;

use App\Entity\Mood;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MoodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', TypeDateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dayMood', ChoiceType::class, [
                'label'   => 'Humeur pendant la journée',
                'choices' => [
                    'Joyeux'  => 'Joyeux',
                    'Neutre'  => 'Neutre',
                    'Fatigué' => 'Fatigué',
                    'Anxieux' => 'Anxieux',
                    'Déprimé' => 'Déprimé'
                ],
                'attr' => [
                    'class' => 'choice-field'
                ]
            ])
            ->add('sleep', ChoiceType::class, [
                'label'   => 'Qualité du sommeil',
                'label'   => 'Qualité du sommeil la nuit précédente',
                'choices' => [
                    'Excellent' => 'Excellent',
                    'Bon'       => 'Bon',
                    'Moyen'     => 'Moyen',
                    'Mauvais'   => 'Mauvais'
                ]
            ])
            ->add('morningMood', TextType::class, [
                'label' => 'Humeur au réveil',
                'attr'  => [
                    'placeholder' => 'Décrivez votre humeur au réveil'
                ]
            ])
            ->add('dayProgram', TextareaType::class, [
                'label'    => 'Programme du jour',
                'required' => false,
                'attr'     => [
                    'placeholder' => 'Quel-est le programme de votre journée ? (optionnel)'
                ]
            ])
            ->add('dayFeeling', TextareaType::class, [
                'label'    => 'Ressenti de la journée',
                'required' => false,
                'attr'     => [
                    'placeholder' => 'Décrivez votre ressenti sur cette journée (optionnel)'
                ]
            ])
            ->add('fallingAsleep', ChoiceType::class, [
                'label'   => 'Qualité de votre endormissement la nuit précédente',
                'choices' => [
                    'Excellent (inf. à 10min)' => 'Excellent (inf. à 10min)',
                    'Bon (inf. à 30min)'       => 'Bon (inf. à 30min)',
                    'Moyen (env. 1h)'          => 'Moyen (env. 1h)',
                    'Long (env. 2h)'           => 'Long (env. 2h)',
                    'Mauvais (sup. à 2h)'      => 'Mauvais (sup. à 2h)'
                ]
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
            'data_class' => Mood::class,
        ]);
    }
}
