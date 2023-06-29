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
use App\Form\Type\AuthForm;

class BaseController extends AbstractController
{
    public function __construct(AuthEncoder $encoder, BusService $busService, AuthService $authService) 
    {
        $this->authEncoder = $encoder;
        $this->busService = $busService;
        $this->authService = $authService;
    }

    public function getAuthFormDetails($class, $data, $request)
    {
        $createForm = $this->createForm($class, $data);
        $user = $this->authService->getFormDetails($request, $createForm);
        return $user;
    }

    public function getBusFormDetails($class, $data, $request)
    {
        $createForm = $this->createForm($class, $data);
        $user = $this->busService->getFormDetails($request, $createForm);
        return $user;
    }

    protected function renderResponse($info, $statusCode = Response::HTTP_OK)
    {
        if ($statusCode >= Response::HTTP_BAD_REQUEST) {
            $this->reportError($info, $statusCode);
        }
        
        return new Response($info, $statusCode);
    }

    /**
     *
     * @param type $statusInfo
     * @param type $statusCode
     *
     */
    protected function reportError($statusInfo, $statusCode = Response::HTTP_BAD_REQUEST)
    {
        return new Response($statusInfo, $statusCode);
    }

}
