<?php
// src/AppBundle/Entity/Article.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="article")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $summary;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
	 * @Assert\DateTime()
     */
    private $publishedAt;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private $numView;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $numLike;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $numUnlike;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $numShare;	
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $tag; 
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $specialTag; 	

	/**
	 * @ORM\Column(type="integer")
	 */
	private $author; 	
	
	/**
     * @ORM\ManyToOne(
     *      targetEntity="Account",
     *      inversedBy="articles"
     * )
	 * @ORM\OrderBy({"publishedAt" = "DESC"})
	 * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    private $account;	
	
    /**
     * @ORM\OneToMany(
     *      targetEntity="Comment",
     *      mappedBy="article",
     *      orphanRemoval=true
     * )
     * @ORM\OrderBy({"publishedAt" = "DESC"})
     */
    private $comments;
    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set summary
     *
     * @param string $summary
     *
     * @return Article
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Article
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
     * @return Article
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
     * Set numView
     *
     * @param integer $numView
     *
     * @return Article
     */
    public function setNumView($numView)
    {
        $this->numView = $numView;

        return $this;
    }

    /**
     * Get numView
     *
     * @return integer
     */
    public function getNumView()
    {
        return $this->numView;
    }

    /**
     * Set numLike
     *
     * @param integer $numLike
     *
     * @return Article
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
     * Set numUnlike
     *
     * @param integer $numUnlike
     *
     * @return Article
     */
    public function setNumUnlike($numUnlike)
    {
        $this->numUnlike = $numUnlike;

        return $this;
    }

    /**
     * Get numUnlike
     *
     * @return integer
     */
    public function getNumUnlike()
    {
        return $this->numUnlike;
    }

    /**
     * Set numShare
     *
     * @param integer $numShare
     *
     * @return Article
     */
    public function setNumShare($numShare)
    {
        $this->numShare = $numShare;

        return $this;
    }

    /**
     * Get numShare
     *
     * @return integer
     */
    public function getNumShare()
    {
        return $this->numShare;
    }

    /**
     * Set tag
     *
     * @param string $tag
     *
     * @return Article
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set specialTag
     *
     * @param string $specialTag
     *
     * @return Article
     */
    public function setSpecialTag($specialTag)
    {
        $this->specialTag = $specialTag;

        return $this;
    }

    /**
     * Get specialTag
     *
     * @return string
     */
    public function getSpecialTag()
    {
        return $this->specialTag;
    }

    /**
     * Set author
     *
     * @param integer $author
     *
     * @return Article
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return integer
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set account
     *
     * @param \AppBundle\Entity\Account $account
     *
     * @return Article
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
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return Article
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
}
