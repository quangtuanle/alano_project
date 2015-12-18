<?php
// src/AppBundle/Entity/Comment.php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
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
	 */
	protected $content;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $publishedAt;
	
    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $article;
	
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
     *      targetEntity="Account",
     *      inversedBy="comments"
     * )
	 * @ORM\OrderBy({"publishedAt" = "DESC"})
	 * @ORM\JoinColumn(name="idWritter", referencedColumnName="id")
     */
    protected $account;	

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
}
