<?php
// src/AppBundle/Entity/Comment.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 * 
 * Defines the properties of the Comment entity represent the blog comments.
 * See http://symfony.com/doc/current/book/doctrine.html#creating-an-entity-class
 *
 * Tip: if you have an existing database, you can generate these entity class automatically.
 * See http://symfony.com/doc/current/cookbook/doctrine/reverse_engineering.html 
 *
 */
class Comment
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="text")
	 * @Assert\NotBlank(message="comment.blank")
	 * @Assert\Length(
	 * 		min = "5",
	 * 		minMessage = "comment.too_short",
	 * 		max = "10000",
	 *		maxMessage = "comment.too_long"
	 * )
	 */
	protected $content;
	
	/**
	 * @ORM\Column(type="datetime")
	 * @Assert\DateTime()
	 */
	protected $publishedAt;
	
	/**
	 * @ORM\Column(type="string")
	 * @Assert\Email()
	 */
	private $authorEmail;
	
    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $article;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $post;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $numLike;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $numUnLike;
	
	/**
	 * ORM\Column(type="string", length=50)
	 */
	//private $author; 	
	
	/**
     * @ORM\ManyToOne(
     *      targetEntity="User",
     *      inversedBy="comments"
     * )
	 * @ORM\OrderBy({"publishedAt" = "DESC"})
	 * @ORM\JoinColumn(name="idWritter", referencedColumnName="id")
     */
    protected $user;	
	
	public function __construct()
	{
		$this->publishedAt = new \DateTime();
	}
	
	/**
	 * @Assert\IsTrue(message = "comment.is_spam")
	 */
	public function isLegitComment()
	{
		$containsInvalidCharacters = false !== strpos($this->content, '@');
		
		return !$containsInvalidCharacters;
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
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set publishedAt
     *
     * @param \DateTime $publishedAt
     *
     * @return Comment
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get publishedAt
     *
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * Set numLike
     *
     * @param integer $numLike
     *
     * @return Comment
     */
    public function setNumLike($numLike)
    {
        $this->numLike = $numLike;

        return $this;
    }

    /**
     * Get numLike
     *
     * @return integer
     */
    public function getNumLike()
    {
        return $this->numLike;
    }

    /**
     * Set numUnLike
     *
     * @param integer $numUnLike
     *
     * @return Comment
     */
    public function setNumUnLike($numUnLike)
    {
        $this->numUnLike = $numUnLike;

        return $this;
    }

    /**
     * Get numUnLike
     *
     * @return integer
     */
    public function getNumUnLike()
    {
        return $this->numUnLike;
    }

    /**
     * Set article
     *
     * @param \AppBundle\Entity\Article $article
     *
     * @return Comment
     */
    public function setArticle(\AppBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \AppBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set account
     *
     * @param \AppBundle\Entity\Account $account
     *
     * @return Comment
     */
    public function setAccount(\AppBundle\Entity\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \AppBundle\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Comment
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
	
	

    /**
     * Set authorEmail
     *
     * @param string $authorEmail
     * @return Comment
     */
    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;

        return $this;
    }

    /**
     * Get authorEmail
     *
     * @return string 
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    /**
     * Set post
     *
     * @param \AppBundle\Entity\Post $post
     * @return Comment
     */
    public function setPost(\AppBundle\Entity\Post $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \AppBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }
}
