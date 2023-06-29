<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Bus;
use App\Entity\Driver;
use App\Form\Type\BusForm;
use App\Service\BusService;

class BusController extends BaseController
{
    public const BUS_INSERTED = 'New bus details inserted successfully';
    public const BUS_DELETED = 'Bus removed successfully';
    
    public function __construct(BusService $busService) {
        
        $this->busService = $busService;
    }
    /**
     * Method to insert bus.
     */
    public function insert(Request $request)
    {
        $bus = new Bus;
        $busDetails =$this->getBusFormDetails(BusForm::class, $bus, $request);
        $this->busService->insert($busDetails);

        return $this->renderResponse(self::BUS_INSERTED);  
    }

    /**
     * Method to display bus details.
     */
    public function display(Request $request)
    {
        $bus = new Bus;
        $displayBus = $this->busService->db->getRepository(Bus::class)->display();

        return new JsonResponse($displayBus);
    }

    /**
     * Method to update bus details.
     */
    public function update(Request $request)
    {
        $bus = new Bus;
        $updateBusId = $request->get('id');
        $updateBus = $this->busService->db->getRepository(Bus::class)->find($updateBusId);
        $busDetails =$this->getBusFormDetails(BusForm::class, $updateBus, $request);
        $updateDetails = $this->busService->db->getRepository(Bus::class)->update($busDetails);

        return new JsonResponse($updateDetails);
    }

    /**
     * Method to delete bus.
     */
    public function delete(Request $request)
    {
        $bus = new Bus;
        $busId = $request->get('id');
        $deleteBus = $this->busService->db->getRepository(Bus::class)->delete($busId);

        return $this->renderResponse(self::BUS_DELETED);
    }
}