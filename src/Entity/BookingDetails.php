<?php

namespace App\Entity;

use Doctrine\ODM\MongoDB\Mapping\Annotations;
use OpenApi\Annotations as OA;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Bus;
use App\Entity\Passenger;
use App\Entity\Payment;
use App\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="booking_details")
 * @ORM\HasLifecycleCallbacks
 */
class BookingDetails
{
    /**
     * @ORM\Id
     * @ORM\Column(nullable=true)
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="BookingDetails")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Bus", inversedBy="BookingDetails", cascade={"persist"})
     * @ORM\JoinColumn(name="bus_id", referencedColumnName="id")
     */
    private $bus_id;

    /**
     * @var datetime $booked_date
     * 
     * @ORM\Column(type="datetime")
     */
    private $booked_date;

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

    /** 
     * @ORM\OneToMany(targetEntity="Passenger", mappedBy="BookingDetails", cascade={"persist"})
     */
    private $passengers;

    /**
     * @ORM\OneToOne(targetEntity="Payment", mappedBy= "BookingDetails", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="payment_id", referencedColumnName= "id")
     */
    private $payment_id;

    public function __construct()
    {
        $this->passengers = new ArrayCollection();
    }

    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(User $user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getBusId() 
    {
        return $this->bus_id;
    }

    public function setBusId(Bus $id)
    {
        $this->bus_id = $id;

        return $this;
    }

    public function getPaymentId()
    {
        return $this->payment_id;
    }

    public function setPaymentId(Payment $payment_id)
    {
        $this->payment_id = $payment_id;
 
        return $this;
    }

    /**
     * @param \DateTime $booked_date
     */
    public function setBookedDate(\DateTime $booked_date): self
    {
        $this->booked_date = $booked_date;

        return $this;
    }
    /**
     * @return \DateTime
     */
    public function getBookedDate() 
    {
        return $this->booked_date;
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
        $this->created_at = $created_at;
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

    /** 
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created_at = new \DateTime("now");
        $this->booked_date = new \DateTime("now");
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

    public function getPassengers(): Collection
    {
        return $this->passengers;
    }

    public function addPassenger(Passenger $passenger): self
    {
        if (!$this->passengers->contains($passenger)) {
            $this->passengers[] = $passenger;
            $passenger->setBookingDetails($this);
        }

        return $this;
    }

    public function removePassenger(Passenger $passenger): self
    {
        if ($this->passengers->contains($passenger)) {
            $this->passengers->removeElement($passenger);
            if ($passenger->getBookingDetails() === $this) {
                $passenger->setBookingDetails(null);
            }
        }

        return $this;
    }
}
