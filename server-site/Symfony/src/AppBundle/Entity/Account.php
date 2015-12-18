<?php
// src/AppBundle/Entity/Account.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="account")
 */
class Account
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToOne(
     *      targetEntity="Member",
     *      mappedBy="idAccount",
     *      orphanRemoval=true
     * )	
     * @ORM\OneToOne(
     *      targetEntity="Staff",
     *      mappedBy="idAccount",
     *      orphanRemoval=true
     * ) 	 
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=30)
	 */
	protected $username;
	
	/**
	 * @ORM\Column(type="string", length=30, unique=true)
	 */
	protected $password;
	
	/**
	 * @ORM\Column(type="string", length=50, unique=true)
	 */
	protected $email;
	
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	protected $name;
	
	/**
	 * @ORM\Column(type="string", length=5)
	 */
	protected $gender;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $avatar;
	
	/**
	 * @ORM\Column(type="string", length=300)
	 */
	protected $about;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $type;
	
    /**
     * @ORM\OneToMany(
     *      targetEntity="Article",
     *      mappedBy="account",
     *      orphanRemoval=true
     * )
     */
	protected $articles;
	
    /**
     * @ORM\OneToMany(
     *      targetEntity="Comment",
     *      mappedBy="account",
     *      orphanRemoval=true
     * )
     */
	protected $comments;
	
    /**
     * @ORM\OneToOne(
     *      targetEntity="Member",
     *      mappedBy="account",
     *      orphanRemoval=true
     * )
     */
	protected $member;	
	
    /**
     * @ORM\OneToOne(
     *      targetEntity="Staff",
     *      mappedBy="account",
     *      orphanRemoval=true
     * )
     */
	protected $staff;	
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Account
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
     * Set password
     *
     * @param string $password
     *
     * @return Account
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Account
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Account
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Account
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return Account
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set about
     *
     * @param string $about
     *
     * @return Account
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Account
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add article
     *
     * @param \AppBundle\Entity\Article $article
     *
     * @return Account
     */
    public function addArticle(\AppBundle\Entity\Article $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \AppBundle\Entity\Article $article
     */
    public function removeArticle(\AppBundle\Entity\Article $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return Account
     */
    public function addComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\Comment $comment
     */
    public function removeComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set member
     *
     * @param \AppBundle\Entity\Member $member
     *
     * @return Account
     */
    public function setMember(\AppBundle\Entity\Member $member = null)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \AppBundle\Entity\Member
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set staff
     *
     * @param \AppBundle\Entity\Staff $staff
     *
     * @return Account
     */
    public function setStaff(\AppBundle\Entity\Staff $staff = null)
    {
        $this->staff = $staff;

        return $this;
    }

    /**
     * Get staff
     *
     * @return \AppBundle\Entity\Staff
     */
    public function getStaff()
    {
        return $this->staff;
    }
}
