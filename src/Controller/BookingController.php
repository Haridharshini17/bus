<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\Type\BusForm;
use App\Entity\Bus;
use App\Service\BusService;
use App\Repository\BusRepository;
use App\Entity\BookingDetails;
use App\Entity\Passenger;
use App\Form\Type\BookForm;
use App\Entity\Payment;
use App\Form\Type\PaymentForm;

class BookingController extends BaseController
{
    /**
     * Method to search bus.
     */
    public function search(Request $request)
    {
        $bus = new Bus;
        $createForm = $this->createForm(BusForm::class, $bus);
        $busDetails = $this->busService->getFormDetails($request, $createForm);
        $arrival = $busDetails->getArrival();
        $destination = $busDetails->getDestination();
        $busList = $this->db->getRepository(Bus::class)->search($arrival, $destination);
        $formatResponse = $this->busService->dateFormat($busList);

        return new Response($formatResponse);
    
    }

    /**
     * Method to book bus.
     */
    public function book(Request $request)
    {
        $bookingDetails = new BookingDetails;
        $passenger = new Passenger;
        $payment = new payment;
        $bookingDetails->addPassenger($passenger);
        $createForm = $this->createForm(BookForm::class, $bookingDetails);
        $bookingInfo = $this->busService->getFormDetails($request, $createForm);
        $bookBus = $this->db->getRepository(Bus::class)->book($bookingInfo);

        return new Response(Response::HTTP_CREATED);  
    }

    /**
     * Method to make payment for the booking
     */
    public function pay(Request $request)
    {
        $bookingDetailsId = $request->get('id');
        $bookingDetails = new BookingDetails;
        $payment = new Payment;
        $createForm = $this->createForm(PaymentForm::class, $payment);
        $paymentInfo = $this->busService->getFormDetails($request, $createForm);
        $payBus = $this->db->getRepository(Bus::class)->pay($paymentInfo, $bookingDetailsId);
        $this->dbInsert($payBus);
        $this->busService->insertPaymentId($payBus, $bookingDetailsId);

        return new Response(Response::HTTP_CREATED);
    }

    /**
     * Method to cancel ticket
     */
    public function cancel(Request $request)
    {
        $bookingId = $request->get('id');
        $bookBus = $this->db->getRepository(Bus::class)->cancel($bookingId);

        return new Response(Response::HTTP_OK);
    }
}
