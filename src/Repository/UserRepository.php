<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Method to authenticate user.
     */
    public function authenticate(string $email, string $password)
    {
        return (boolean)$this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->andWhere('u.password = :password')
            ->setParameter('password', $password)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
