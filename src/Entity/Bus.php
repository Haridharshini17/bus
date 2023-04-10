<?php

namespace App\Entity;

use Doctrine\ODM\MongoDB\Mapping\Annotations;
use OpenApi\Annotations as OA;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Driver;

/**
 * @ORM\Entity
 * @ORM\Table(name="bus")
 */

class Bus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /*
	 * @ORM\Column(type="string")
     */
    private $name;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $plate_no;

	/**
	 * @ORM\column(type="string")
	 */
	private $arrival;

	/**
	 * @ORM\column(type="string")
	 */
	private $destination;

	/**
	 * @ORM\column(type="time")
	 */
	private $time;

	/**
	 * @ORM\column(type="integer")
	 */
	private $cost;

	/**
	 * @ORM\column(type="integer")
	 */
	private $available_seats;

	/**
     * @ORM\OneToOne(targetEntity="Driver", mappedBy="Bus", cascade={"persist"})
     */
	private $driver_id;

    /*
     * @ORM\Column(type="number")
     */
    private string $contact;

    /**
     * @var \DateTime $createdAt
     * @ORM\Column(name="created_at", type="datetime", length=100)
     */
    private $createdAt;
    
    /**
     * @var \DateTime $updatedAt
     * @ORM\Column(name="updated_at", type="datetime", length=100)
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

	public function setPlateNo(int $plate_no): self
	{
		$this->plate_no = $plate_no;

		return $this;
	}

    public function getPlateNo(): ?int
    {
        return $this->plate_no;
    }

	public function setArrival(string $arrival): self
	{
		$this->arrival = $arrival;

		return $this;
	}

	public function getArrival(): ?string
	{
		return $this->arrival;
	}

	public function setDestination(string $destination): self
	{
		$this->destination = $destination;

		return $this;
	}

	public function getDestination(): ?string 
	{
		return $this->destination;
	}

	public function setTime(int $time): self
	{
		$this->time = $time;

		return $this;
	}

	public function getTime(): ?string
	{
		return $this->time;
	}

	public function setCost(int $cost): self
	{
		$this->cost = $cost;

		return $this;
	}

	public function getCost(): ?int
	{
		return $this->cost;
	}

	public function setAvailableSeats(int $available_seats): self
	{
		$this->available_seats = $available_seats;

		return $this;
	}

	public function getAvailableSeats(): ?int
	{
		return $this->available_seats;
	}

	public function setDriverId(int $driver_id): self
	{
		$this->driver_id = $driver_id;

		return $this;
	}

	public function getDriverId(): ?int
	{
		return $this->driver_id;
	}

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAtAt;
    }
}