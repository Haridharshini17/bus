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

class BusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bus::class);
    }

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
}

