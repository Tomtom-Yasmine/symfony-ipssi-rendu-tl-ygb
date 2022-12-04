<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddToCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product_id', HiddenType::class, [
                'required' => true,
            ])
            ->add('color')
            ->add('quantity')
            ->addEventListener(FormEvents::PRE_SET_DATA, function ($event) use ($options) {
                $product = $options['product'];
                if (! $product) {
                    return;
                }
                $quantityMax = min($product->getAvailableQuantity(), 10);
                $form = $event->getForm();
                $form
                    ->add('color', ChoiceType::class, [
                        'required' => true,
                        'choices' => array_combine($product->getColors(), $product->getColors()),
                    ])
                    ->add('quantity', ChoiceType::class, [
                        'required' => true,
                        'choices' => array_combine(range(1, $quantityMax), range(1, $quantityMax)),
                    ]);
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'product' => null,
        ]);
    }
}
