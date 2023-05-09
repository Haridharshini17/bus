<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface as AuthEncoder;
use App\Service\BusService;
use App\Service\AuthService;

class BaseController extends AbstractController
{
    public function __construct(
        AuthEncoder $encoder, 
        ManagerRegistry $doctrine, 
        EntityManagerInterface $entityManager, 
        BusService $busService,
        AuthService $authService
    ) {
        $this->authEncoder = $encoder;
        $this->db = $doctrine->getManager();
        $this->doctrine = $doctrine;
        $this->busService = $busService;
        $this->authService = $authService;
    }

    /**
     * Method for common insert process.
     */
    public function dbInsert($user)
    {
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush($user);
    }
}
