<?php

namespace App\Entity;

use Doctrine\ODM\MongoDB\Mapping\Annotations;
use OpenApi\Annotations as OA;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="payment")
 * @ORM\HasLifecycleCallbacks
 */

class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @ORM\OneToOne(targetEntity="BookingDetails", mappedBy="Payment", cascade={"persist"})
     * @ORM\JoinColumn(name="id", referencedColumnName="payment_id")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $medium;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $amount_paid;

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

    public function setMedium(string $medium): self
    {
        $this->medium = $medium;

        return $this;
    }

    public function getMedium(): ?string
    {
        return $this->medium;
    }

	public function setAmountPaid(int $amount_paid): self
	{
		$this->amount_paid = $amount_paid;

		return $this->amount_paid;
	}

    public function getAmountPaid() 
    {
        return $this->amount_paid;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $createdAt
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
}