<?php

namespace App\Form;

use App\Enum\Hours;
use App\Enum\Position;
use App\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('active')
            ->add('birthdate', DateType::class, ['widget' => 'single_text'])
            ->add('employed_since', DateType::class, ['widget' => 'single_text'])
            ->add('employed_until', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('hours', ChoiceType::class, [
                'choices' => [
                    '8 hours' => Hours::EIGHT,
                    '6 hours' => Hours::SIX,
                    '4 hours' => Hours::FOUR
                ],
                'placeholder' => 'Select hours'
            ])
            ->add('salary')
            ->add('position', ChoiceType::class, [
                'choices' => [
                    'Manager' => Position::MANAGER,
                    'Account Manager' => Position::ACCOUNT_MANAGER,
                    'QA Manager' => Position::QA_MANAGER,
                    'Dev Manager' => Position::DEV_MANAGER,
                    'CEO' => Position::CEO,
                    'COO' => Position::COO,
                    'Backend Dev' => Position::BACKEND_DEV,
                    'Frontend Dev' => Position::FRONTEND_DEV,
                    'QA Tester' => Position::QA_TESTER
                ],
                'placeholder' => 'Select position'
            ])
            ->add('manager', null, [
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
