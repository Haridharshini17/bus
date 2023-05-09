<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;
use App\Entity\Bus;
use App\Entity\BookingDetails;
use App\Entity\Passenger;

use App\Controller\BaseController;

class BusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, BaseController $baseController, ManagerRegistry $doctrine)
    {
        parent::__construct($registry, Bus::class);
        $this->baseController = $baseController;
        $this->db = $doctrine->getManager();
    }

    /**
     * Method to search bus based on arrival and destination.
     */
    public function search(string $arrival, string $destination)
    {   
        return $this->createQueryBuilder('b')
            ->select('b.id,b.name,b.plate_no,b.arrival_time,b.destination_time,b.cost,b.total_seats - count(p.id) as available_seats')
            ->leftJoin(BookingDetails::class, 'bd', Join::WITH, 'b.id = bd.bus_id')
            ->leftJoin(Passenger::class, 'p', Join::WITH, 'p.booking_details_id = bd.id')
            ->andwhere('b.arrival = :arrival')
            ->setParameter('arrival', $arrival)
            ->andWhere('b.destination = :destination')
            ->setParameter('destination', $destination)
            ->groupBy('b.id')
            ->getQuery()
            ->getResult();
    }

    /**
     * Method to book bus from form details.
     */
    public function book($bookingInfo)
    {
        $insertBusInfo = $this->baseController->dbInsert($bookingInfo);
        $passengerInfo = $bookingInfo->getPassengerArray();
        array_walk(
            $passengerInfo, function ($passenger, $value) use (&$bookingInfo) {
                    $bookingId = $this->db->getRepository(BookingDetails::class)->find($bookingInfo->getId());
                    $passenger->setBookingDetailsId($bookingId);
                    $this->baseController->dbInsert($passenger);
            }
        );
    }
}

