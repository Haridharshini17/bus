<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Payment;

class PaymentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('medium', ChoiceType::class, [
                	'choices' => [
                        'GooglePay' => 'gpay',
                        'PhonePay' => 'phonepy',
                        'Credit Card' => 'CC card'
					]
			    ]
			)
			->getForm()
            ->add('Save', SubmitType::class);  
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
            'data_class' => Payment::class,
            'allow_extra_fields' => true
            ]
        );
    }
}