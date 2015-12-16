<?php
// src/AppBundle/Entity/Member.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Account;

/**
 * @ORM\Entity
 * @ORM\Table(name="member")
 */
class Member extends Account
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
	private $credit;

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Member
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
     * Set credit
     *
     * @param string $credit
     *
     * @return Member
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;

        return $this;
    }

    /**
     * Get credit
     *
     * @return string
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Member
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
