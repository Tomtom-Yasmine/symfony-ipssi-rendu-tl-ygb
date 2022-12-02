<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password')
            ->add('firstName')
            ->add('lastName')
            ->add('isSeller', CheckboxType::class, [
                'label'    => 'Vendeur',
                'required' => false,
                'mapped' => false,
                'data' => in_array("ROLE_SELLER", $builder->getData()->getRoles()), 
            ])
            ->add('isAdmin', CheckboxType::class, [
                'label'    => 'Admin',
                'required' => false,
                'mapped' => false,
                'data' => in_array("ROLE_ADMIN", $builder->getData()->getRoles()), 
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
