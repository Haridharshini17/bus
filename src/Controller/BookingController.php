<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Bus;
use App\Entity\BookingDetails;
use App\Entity\Passenger;
use App\Entity\Payment;
use App\Form\Type\BusForm;
use App\Service\BusService;
use App\Repository\BusRepository;
use App\Repository\BaseRepository;
use App\Form\Type\BookForm;
use App\Form\Type\PaymentForm;

class BookingController extends BaseController
{
    public const BOOK_BUS = 'Bus ticket booked successfully';
    public const PAYMENT_DONE = 'Payment done successfully';
    public const CANCEL = 'Bus ticket cancelled successfully';

    public function __construct(BusService $busService) 
    {
        $this->busService = $busService;
        $this->repo = $this->busService->db->getRepository(Bus::class);
    }
    /**
     * Method to search bus.
     */
    public function search(Request $request)
    {
        $bus = new Bus;
        $busDetails = $this->getBusFormDetails(BusForm::class, $bus, $request);
        $arrival = $busDetails->getArrival();
        $destination = $busDetails->getDestination();
        $busList = $this->repo->search($arrival, $destination);
        $formatResponse = $this->busService->dateFormat($busList);

        return new JsonResponse($formatResponse);
    
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
        $bookingInfo = $this->getBusFormDetails(BookForm::class, $bookingDetails, $request);
        $bookBus = $this->repo->book($bookingInfo);

        return $this->renderResponse(self::BOOK_BUS);  
    }

    /**
     * Method to make payment for the booking
     */
    public function pay(Request $request)
    {
        $bookingDetailsId = $request->get('id');
        $bookingDetails = new BookingDetails;
        $payment = new Payment;
        $paymentInfo = $this->getBusFormDetails(PaymentForm::class, $payment, $request);
        $payBus = $this->repo->pay($paymentInfo, $bookingDetailsId);
        $this->busService->pay($payBus);
        $this->busService->updatePaymentId($payBus, $bookingDetailsId);

        return $this->renderResponse(self::PAYMENT_DONE);
    }

    /**
     * Method to cancel ticket
     */
    public function cancel(Request $request)
    {
        $bookingId = $request->get('id');
        $bookBus = $this->repo->cancel($bookingId);

        return $this->renderResponse(self::CANCEL);
    }
}
