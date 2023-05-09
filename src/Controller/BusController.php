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
use App\Service\BusService;

class BusController extends BaseController
{
    public const INVALID_DETAILS = 'Provide Invalid details';

    /**
     * Method to insert bus.
     */
    public function insert(Request $request)
    {
        $bus = new Bus;
        $createForm = $this->createForm(BusForm::class, $bus);
        $busDetails = $this->busService->getFormDetails($request, $createForm);
        $this->dbInsert($busDetails);

        return new Response(Response::HTTP_CREATED);
    }
   
}