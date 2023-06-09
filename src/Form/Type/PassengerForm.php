<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Entity\Passenger;

class PassengerForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            $builder
                ->add('name')
                ->add('age');
            
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
            'data_class' => Passenger::class,
            'allow_extra_fields' => true
            ]
        );
    }
    public function getDefaultOptions(array $options)
    {
        return array(
             'csrf_protection' => false
        );
    }
}