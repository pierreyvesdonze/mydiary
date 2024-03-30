<?php

namespace App\Form;

use App\Entity\RoutineTask;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class RoutineTaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startAt', TimeType::class, [
                'label' => 'Heure de début',
                'attr' => [
                    'class' => 'routine-form-select-input',
                    'placeholder' => 'Heure de début'
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'textarea-custom',
                    'placeholder' => 'Décrivez votre tâche'
                ]
            ])
            ->add('finishAt', TimeType::class, [
                'label' => 'Heure de fin',
                'attr' => [
                    'class' => 'routine-form-select-input',
                    'placeholder' => 'Heure de fin'
                ],
                'constraints' => [
                    new NotBlank(),
                ],
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
            'data_class' => RoutineTask::class,
        ]);
    }
}
