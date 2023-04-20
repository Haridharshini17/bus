<?php

namespace App\Entity;

use Doctrine\ODM\MongoDB\Mapping\Annotations;
use OpenApi\Annotations as OA;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Bus;
use App\Entity\Passenger;
use App\Entity\Payment;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingDetailsRepository")
 * @ORM\Table(name="booking_details")
 * @ORM\HasLifecycleCallbacks
 */
class BookingDetails
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

	/**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="BookingDetails", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user_id;
	
    /**
     * @ORM\ManyToOne(targetEntity="Bus", inversedBy="BookingDetails", cascade={"persist"})
     * @ORM\JoinColumn(name="bus_id", referencedColumnName="id")
     */
    private $bus_id;

    /**
     * @ORM\Column(type="integer")
     */
    private string $booked_date;

    /**
     * @ORM\OneToOne(targetEntity="Payment", inversedBy="BookingDetails", cascade={"persist"})
     * @ORM\JoinColumn(name="payment_id",     referencedColumnName="id")
     */
    private string $payment_id;

    /**
     * @var \DateTime $created_at
     * @ORM\Column(name="created_at", type="datetime", length=100)
     */
    private $created_at;
    
    /**
     * @var \DateTime $updated_at
     * @ORM\Column(name="updated_at", type="datetime", length=100)
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

	public function setBusId(int $bus_id): self
	{
		$this->bus_id = $bus_id;

		return $this->bus_id;
	}

    public function getBusId() 
    {
        return $this->bus_id;
    }

	public function setBookedDate($booked_date): self
	{
		$this->booked_date = $booked_date;

		return $this->booked_date;
	}

    public function getBookedDate() 
    {
        return $this->booked_date;
    }

	public function setPaymentId(int $payment_id): self
	{
		$this->payment_id= $payment_id;

		return $this->payment_id;
	}

    public function getPaymentId() 
    {
        return $this->payment_id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt(\DateTime $created_at)
    {
        $this->createdAt = $created_at;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param \DateTime $updated_at
     */
    public function setUpdatedAt(\DateTime $updated_at)
    {
        $this->updated_at = $updated_at;
    }
}
