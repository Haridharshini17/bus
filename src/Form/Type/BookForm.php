<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\BookingDetails;
use App\Entity\Passenger;
use App\Form\Type\PassengerForm;

class BookForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', IntegerType::class)
            ->add(
                'user_id', EntityType::class, array(
                     'class' => 'App\Entity\User',
                     'choice_label' => 'id'
                )
            )
            ->add(
                'bus_id', EntityType::class, array(
                    'class' => 'App\Entity\Bus',
                    'choice_label' => 'id'
                )
            )
            ->add(
                'passengers', CollectionType::class, [
                'entry_type' => PassengerForm::class,
                'entry_options' => ['label' => false],
                'allow_add' => true
                ]
            )
            ->getForm()
            ->add('Save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            array(
            'data_class' => BookingDetails::class,
            'allow_extra_fields' => true
            )
        );
    }
    public function getDefaultOptions(array $options)
    {
        return array(
             'csrf_protection' => false
        );
    }
}
