<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\Type\BusForm;
use App\Entity\Bus;
use App\Service\AuthService;
use App\Repository\BusRepository;

class PassengerController extends BaseController
{
    public function searchBus(Request $request)
    {
        $bus = new Bus;
        $createForm = $this->createForm(BusForm::class, $bus);
        $this->authService->submitForm($request, $createForm);
        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $busDetails = $createForm->getData();
            $arrival = $busDetails->getArrival();
            $destination = $busDetails->getDestination();
            $busList = $this->db->getRepository(Bus::class)->search($arrival, $destination);
            $formatResponse = $this->authService->dateFormat($busList);
            return new Response($formatResponse);
        }
    }

    public function bookBus(Request $request)
    {
        $busList = $this->searchBus();
    }
}