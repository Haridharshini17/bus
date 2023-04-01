<?php

namespace App\Entity;

use Doctrine\ODM\MongoDB\Mapping\Annotations;
use OpenApi\Annotations as OA;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="role")
 */

class Role 
{
    /**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
    private $id;
    
	/**
     * @ORM\OneToMany(targetEntity="User", mappedBy="Role", cascade={"persist"})
 	 */
	private $user = null;
	/**
	 * @ORM\Column(type="text")
	 */
    private string $role;
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

	public function setRole(string $role): self
	{
		$this->role = $role;

		return $this;
	}

    public function getRole(): ?string
    {
		return $this->role;
	}

    public function __toString()
    {  
        return $this->getRole();
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
