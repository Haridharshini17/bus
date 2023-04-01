<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;
use App\Form\Transformer\RoleTransformer;

class AuthForm extends AbstractType
{
    private $roleTransformer;

    public function __construct(RoleTransformer $roleTransformer)
    {
        $this->roleTransformer = $roleTransformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('id', IntegerType::class)
        ->add('email', TextType::class)
        ->add('password', TextType::class)
        ->add('role', TextType::class)
        ->getForm()
        ->add('Save', SubmitType::class);

        $builder->get('role')
        ->addModelTransformer($this->roleTransformer);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'allow_extra_fields' => true
        ));
    }
    public function getDefaultOptions(array $options)
    {
        return array(
             'csrf_protection' => false
        );
    }
}
