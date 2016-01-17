<?php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
 class User implements AdvancedUserInterface, \Serializable
 {
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToOne(
     *      targetEntity="Member",
     *      mappedBy="idUser",
     *      orphanRemoval=true
     * )	
     * @ORM\OneToOne(
     *      targetEntity="Staff",
     *      mappedBy="idUser",
     *      orphanRemoval=true
     * ) 		 
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length=25, unique=true)
	 * @Assert\NotBlank()
	 */
	private $username;
	
	/**
	 * @Assert\NotBlank()
	 * @Assert\Length(max=4096)
	 */
	private $plainPassword;
	
	/**
	 * The below length depends on the "algorithm" you use for encoding 
	 * the password, but this works well with bcrypt (change to md5)
	 * 
	 * @ORM\Column(type="string", length=64)
	 */
	private $password;
	
	/**
	 * @ORM\Column(type="string", length=60, unique=true)
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 */ 
	private $email;
	
	/**
	 * @ORM\Column(name="is_active", type="boolean")
	 */
	private $isActive;
	
	// Another attribute
	
	/**
	 * @ORM\Column(type="string", length=50, nullable=true)
	 */
	protected $name;
	
	/**
	 * @ORM\Column(type="string", length=5, nullable=true)
	 */
	protected $gender;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $avatar;
	
	/**
	 * @ORM\Column(type="string", length=300, nullable=true)
	 */
	protected $about;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $type;
	
    /**
     * @ORM\OneToMany(
     *      targetEntity="Article",
     *      mappedBy="user",
     *      orphanRemoval=true
     * )
     */
	protected $articles;
	
    /**
     * @ORM\OneToMany(
     *      targetEntity="Comment",
     *      mappedBy="user",
     *      orphanRemoval=true
     * )
     */
	protected $comments;
	
    /**
     * @ORM\OneToOne(
     *      targetEntity="Member",
     *      mappedBy="user",
     *      orphanRemoval=true
     * )
     */
	protected $member;	
	
    /**
     * @ORM\OneToOne(
     *      targetEntity="Staff",
     *      mappedBy="user",
     *      orphanRemoval=true
     * )
     */
	protected $staff;	
	
	public function __construct()
	{
		$this->isActive = true;
		// may not be needed, see section on salt below
		// $this->salt = md5(uniqid(null, true));
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function getSalt()
	{
		// See "Do you need to use a Salt?" at
		// http://symfony.com/doc/current/cookbook/security/entity_provider.html 
		// we're using bcrypt in security.yml to encode the password, so
		// the salt value is built-in and you don't have generate one
		
		// you *may* need a real salt depending on your encoder
		// see section on salt below 
		return null;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	/**
	 * Returns the roles or permissions granted to the user for security.
	 */
	public function getRoles()
	{
		//return array('ROLE_USER');
		
		$roles = $this->roles;

        // guarantees that a user always has at least one role for security
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
		
	}
	
	/**
	 * Removes sensitive data from the user.
	 */ 
	public function eraseCredentials()
	{
		// if you had a plainPassword property, you'd nullify it here
		// $this->plainPassword = null;
	}
	
	/** @see \Serializable::serialize() */
	public function serialize()
	{
		return serialize(array(
			$this->id,
			$this->username,
			$this->password,
			$this->isActive,
			// see section on salt below
			// $this->salt,
		));
	}
	
	/** @see \Serializable::unserialize() */
	public function unserialize($serialized)
	{
		list (
			$this->id,
			$this->username,
			$this->password,
			$this->isActive,
			// see section on salt below
			// $this->salt,
		) = unserialize($serialized);
	}
	
	public function isAccountNonExpired()
	{
		return true;
	}
	
	public function isAccountNonLocked()
	{
		return true;
	}
	
	public function isCredentialsNonExpired()
	{
		return true;
	}
	
	public function isEnabled()
	{
		return $this->isActive;
	}
	
	public function getPlainPassword()
	{
		return $this->plainPassword;
	}
	
	public function setPlainPassword($plainPassword)
	{
		$this->plainPassword = $plainPassword;
		
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

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * Add articles
     *
     * @param \AppBundle\Entity\Article $articles
     * @return User
     */
    public function addArticle(\AppBundle\Entity\Article $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * Remove articles
     *
     * @param \AppBundle\Entity\Article $articles
     */
    public function removeArticle(\AppBundle\Entity\Article $articles)
    {
        $this->articles->removeElement($articles);
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
     * Add comments
     *
     * @param \AppBundle\Entity\Comment $comments
     * @return User
     */
    public function addComment(\AppBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \AppBundle\Entity\Comment $comments
     */
    public function removeComment(\AppBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
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
     * @return User
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
     * @return User
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
