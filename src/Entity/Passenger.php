<?php

namespace App\Entity;

use Doctrine\ODM\MongoDB\Mapping\Annotations;
use OpenApi\Annotations as OA;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App/Repository/PassengerRepository")
 * @ORM\Table(name="passenger")
 * @ORM\HasLifecycleCallbacks
 */

class Passenger
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="integer")
     */
    private string $booking_details_id;

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

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

	public function setAge(int $age): self
	{
		$this->age = $age;

		return $this->age;
	}

    public function getAge() 
    {
        return $this->age;
    }

	public function setBookingDetailsId(int $booking_details_id): self
	{
		$this->booking_details_id = $booking_details_id;

		return $this->booking_details_id;
	}

    public function getBookingDetailsId() 
    {
        return $this->booking_details_id;
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
     * @return \DateTime $updated_at
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