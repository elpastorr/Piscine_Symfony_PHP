<?php

namespace App\Form;

use App\Entity\Employee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('birthdate')
            ->add('active')
            ->add('employed_since')
            ->add('employed_until', null, ['required' => false])
            ->add('hours', ChoiceType::class, [
                'choices' => [
                    '8 hours' => '8',
                    '6 hours' => '6',
                    '4 hours' => '4',
                ],
            ])
            ->add('salary')
            ->add('position', ChoiceType::class, [
                'choices' => [
                    'Manager' => 'manager',
                    'Account Manager' => 'account_manager',
                    'QA Manager' => 'qa_manager',
                    'Dev Manager' => 'dev_manager',
                    'CEO' => 'ceo',
                    'COO' => 'coo',
                    'Backend Dev' => 'backend_dev',
                    'Frontend Dev' => 'frontend_dev',
                    'QA Tester' => 'qa_tester',
                ],
            ])
            ->add('manager', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'firstname',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
