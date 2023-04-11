<?php

namespace App\Entity;

use Doctrine\ODM\MongoDB\Mapping\Annotations;
use OpenApi\Annotations as OA;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Bus;

/**
 * @ORM\Entity
 * @ORM\Table(name="driver")
 */

class Driver
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Bus", mappedBy="driver_id")
     */
    private $bus;
    
    /**
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
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

    public function __toString()
    {
        return $this->getName();
    }

	public function setContact(string $contact): self
	{
		$this->contact = $contact;

		return $this->contact;
	}

    public function getContact() 
    {
        return $this->contact;
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
