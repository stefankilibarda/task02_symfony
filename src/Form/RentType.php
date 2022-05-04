<?php

namespace App\Form;

use App\Entity\Rent;
use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder
        //     ->add('deliverer')
        //     ->add('vehicle', ChoiceType::class, [
        //         'class' => Vehicle::class,
                // 'choice_label' => function($vehicle) {
                //     return $vehicle->getBrand();
                // }
        //     ])
        // ;

        $builder
            ->add('deliverer')
            ->add('vehicles', EntityType::class, [
                'class' => Vehicle::class,
                'choice_label' => function($vehicle) {
                    return $vehicle->getBrand();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rent::class,
        ]);
    }
}
