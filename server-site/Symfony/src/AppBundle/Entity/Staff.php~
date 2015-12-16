<?php
// src/AppBundle/Entity/Staff.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Account;

/**
 * @ORM\Entity
 * @ORM\Table(name="staff")
 */
class Staff extends Account
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 */
	protected $id;	
	
	/**
	 * @ORM\Column(type="string", length=30, unique=true)
	 */
	protected $username;
	
	/**
	 * @ORM\Column(type="string", length=10)
	 */
	private $numIdentity;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $address;

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Staff
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set numIdentity
     *
     * @param string $numIdentity
     *
     * @return Staff
     */
    public function setNumIdentity($numIdentity)
    {
        $this->numIdentity = $numIdentity;

        return $this;
    }

    /**
     * Get numIdentity
     *
     * @return string
     */
    public function getNumIdentity()
    {
        return $this->numIdentity;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Staff
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Staff
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
