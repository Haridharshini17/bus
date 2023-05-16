<?php

namespace App\Service;

use App\Entity\BookingDetails;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class BusService
{
    public function __construct(ManagerRegistry $doctrine, EntityManagerInterface $entityManager) 
    {
        $this->db = $doctrine->getManager();
        $this->doctrine = $doctrine;
    } 
    /**
     * Method to format the arrival and destination time.
     */
    public function dateFormat($response)
    {
        array_walk(
            $response, function ($value,$key) use (&$response) {
                $response[$key]['arrival_time'] = date_format($value['arrival_time'], 'H:i:s');
                $response[$key]['destination_time'] = date_format($value['destination_time'], 'H:i:s');
            }
        );

        return json_encode($response); //check
    }

    /**
     * Method to submit and get form details.
     */
    public function getFormDetails($request, $createForm) 
    {
        $createForm->handleRequest($request);
        $createForm->submit(json_decode($request->getContent(), true));
        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $formDetails = $createForm->getData();
            return $formDetails;
        }

        return new Response(Response::INVALID_DETAILS);
    }

    /**
     * Method to insert payment Id in Booking details table.
     */

    public function insertPaymentId($payBus, $bookingDetailsId)
    {
        $entityManager = $this->doctrine->getManager();
        $bookingObj = $this->db->getRepository(BookingDetails::class)->find($bookingDetailsId);
        $bookingObj->setPaymentId($payBus);
        $entityManager->persist($bookingObj); //common
        $entityManager->flush($bookingObj); //comon
    }
}
