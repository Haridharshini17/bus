<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Bus;
use App\Form\Transformer\DriverTransformer;

class BusForm extends AbstractType
{
	private $driverTransformer;

	public function __construct(DriverTransformer $driverTransformer)
	{
	    $this->driverTransformer = $driverTransformer;
	}
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        	->add('id', IntegerType::class)
        	->add('name', TextType::class)
        	->add('plate_no', IntegerType::class)
	    	->add('arrival', TextType::class)
	    	->add('destination', TextType::class)
	    	->add('time', TimeType::class, [
				'widget' => 'single_text',
				'minutes' => array("0"=>"0","15"=>"15","30"=>"30","45"=>"45"),
			])
	    	->add('cost', IntegerType::class)
	    	->add('available_seats', IntegerType::class)
	    	->add('driver_id', TextType::class)
            ->getForm()
            ->add('Save', SubmitType::class);
		
		$builder->get('driver_id')
			->addModelTransformer($this->driverTransformer);
    }
	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults(
			array(
				'data_class' => Bus::class,
				'allow_extra_fields' => true
			)
		);
	}
	public function getDefaultOptions(array $options)
	{
		return array(
			'csfr_protection' => false
		);
	}
}