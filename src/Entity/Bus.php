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
    
    /**
	 * @ORM\column(type="string")
     */
    private $name;

	/**
	 * @ORM\column(type="integer")
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
     * @ORM\OneToOne(targetEntity="Driver", inversedBy="Bus")
	 * @ORM\JoinColumn(name="driver_id",     referencedColumnName="id")
     */
	private $driver_id;

    /*
     * @ORM\Column(type="number")
     */
    private string $contact;

    /**
     * @var datetime $created_at
	 * 
     * @ORM\Column(type="datetime")
     */
    private $created_at;
    
    /**
     * @var datetime $updated_at
	 * 
     * @ORM\Column(type="datetime", nullable = true)
     */
    private $updated_at;

    public function setId(int $id)
    {
        $this->id = $id;
    }

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

	public function setTime($time)
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

	public function getDriverId()
	{
		return $this->driver_id;
	}

	public function setDriverId(Driver $name): self
	{
		$this->driver_id = $name;

		return $this;
	}

	/**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created_at = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     *
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated_at = new \DateTime("now");
    }

    /**
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}