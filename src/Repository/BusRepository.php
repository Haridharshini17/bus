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
            ->select('b.id, b.name, b.plate_no,b.arrival_time,b.destination_time,b.cost,b.total_seats - count(p.id) as available_seats')
            ->leftJoin(BookingDetails::class, 'bd', Join::WITH, 'b.id = bd.bus_id')
            ->leftJoin(Passenger::class, 'p', Join::WITH, 'p.bookingDetails = bd.id')
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
        return $this->baseController->dbInsert($bookingInfo);
    }

    /**
     * Method to make payment for bus from the details.
     */
    public function pay($paymentInfo, int $bookingDetailsId)
    {
        return $paymentInfo->setAmountPaid($this->createQueryBuilder('b')
            ->select('b.cost*count(p.id)')
            ->leftJoin(BookingDetails::class, 'bd', Join::WITH, 'bd.bus_id = b.id')
            ->leftJoin(Passenger::class, 'p', Join::WITH, 'bd.id = p.bookingDetails')
            ->andwhere('p.bookingDetails = :bookingDetails')
            ->setParameter('bookingDetails', $bookingDetailsId)
            ->groupBy('p.bookingDetails', 'b.cost')
            ->getQuery()
            ->getSingleScalarResult());
    }

    public function cancel(int $bookingId)
    {
        return $this->createQueryBuilder('bd')
            ->delete(BookingDetails::class,'bd')
            ->where('bd.id = :id')
            ->setParameter('id', $bookingId)
            ->getQuery()
            ->getResult();
    }
}
