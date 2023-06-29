<?php

namespace App\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Driver;

Class DriverTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($name): string
    { 
        if (null === $name) {
          
            return "";
        }
     
        return $name->getId();
    }

    public function reverseTransform($name): ?Driver
    {
        if (!$name) {
            return null;
        }
        $name = $this->entityManager
            ->getRepository(Driver::class)
            ->findOneByName($name);
        if (null === $name) {
            throw new TransformationFailedException(
                sprintf(
                    'An name "%s" does not exist!', $name
                )
            );
        }

        return $name;
    }
}
