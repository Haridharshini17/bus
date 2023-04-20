<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Bus;
use App\Entity\Driver;
use App\Form\Type\BusForm;
use App\Service\AuthService;

class BusController extends BaseController
{
    public const INVALID_DETAILS = 'Provide Invalid details';

    public function insertBus(Request $request)
    {
        $bus = new Bus;
        $createForm = $this->createForm(BusForm::class, $bus);
        $this->authService->submitForm($request, $createForm);
        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $busDetails = $createForm->getData();
            $this->dbInsert($busDetails);
            return new Response(Response::HTTP_CREATED);
        }
        return new Response(Response::INVALID_DETAILS);
    }
   
}