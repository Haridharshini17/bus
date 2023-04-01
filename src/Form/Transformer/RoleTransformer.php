<?php

namespace App\Form\Transformer;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use App\Entity\Role;

Class RoleTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($role): string
    { 
        if (null === $role) {
          
            return "";
        }
     
        return $role->getId();
    }

    public function reverseTransform($role): ?Role
    {
        if (!$role)  {
            return null;
        }
        $role = $this->entityManager
            ->getRepository(Role::class)
            ->findOneByRole($role);
        if (null === $role)  {
            throw new TransformationFailedException(sprintf(
                'An role "%s" does not exist!',$role
            ));
        }

        return $role;
    }
}