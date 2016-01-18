<?php
// src/AppBundle/Entity/Product.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="news")
 */
class News
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $title;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $summary;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $content;
	
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	protected $author;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $publishedAt;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $linkSource;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $statusLink;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $numLike;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $numShare;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $numComment;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $sameNews;
	
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	protected $category;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $tag;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $numSame;

    /**
	 * @ORM\Column(type="integer")
	 */
	protected $hot;

    /**
	 * @ORM\Column(type="integer")
	 */
	protected $original;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $reviewed;

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
     * @return News
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
     * @return News
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
     * @return News
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
     * Set author
     *
     * @param string $author
     *
     * @return News
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set publishedAt
     *
     * @param \DateTime $publishedAt
     *
     * @return News
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
     * Set linkSource
     *
     * @param string $linkSource
     *
     * @return News
     */
    public function setLinkSource($linkSource)
    {
        $this->linkSource = $linkSource;

        return $this;
    }

    /**
     * Get linkSource
     *
     * @return string
     */
    public function getLinkSource()
    {
        return $this->linkSource;
    }

    /**
     * Set statusLink
     *
     * @param integer $statusLink
     *
     * @return News
     */
    public function setStatusLink($statusLink)
    {
        $this->statusLink = $statusLink;

        return $this;
    }

    /**
     * Get statusLink
     *
     * @return integer
     */
    public function getStatusLink()
    {
        return $this->statusLink;
    }

    /**
     * Set numLike
     *
     * @param integer $numLike
     *
     * @return News
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
     * Set numShare
     *
     * @param integer $numShare
     *
     * @return News
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
     * Set numComment
     *
     * @param integer $numComment
     *
     * @return News
     */
    public function setNumComment($numComment)
    {
        $this->numComment = $numComment;

        return $this;
    }

    /**
     * Get numComment
     *
     * @return integer
     */
    public function getNumComment()
    {
        return $this->numComment;
    }

    /**
     * Set sameNews
     *
     * @param string $sameNews
     *
     * @return News
     */
    public function setSameNews($sameNews)
    {
        $this->sameNews = $sameNews;

        return $this;
    }

    /**
     * Get sameNews
     *
     * @return string
     */
    public function getSameNews()
    {
        return $this->sameNews;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return News
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set tag
     *
     * @param string $tag
     *
     * @return News
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
     * Set numSame
     *
     * @param integer $numSame
     *
     * @return News
     */
    public function setNumSame($numSame)
    {
        $this->numSame = $numSame;

        return $this;
    }

    /**
     * Get numSame
     *
     * @return integer
     */
    public function getNumSame()
    {
        return $this->numSame;
    }

    /**
     * Set hot
     *
     * @param integer $hot
     *
     * @return News
     */
    public function setHot($hot)
    {
        $this->hot = $hot;

        return $this;
    }

    /**
     * Get hot
     *
     * @return integer
     */
    public function getHot()
    {
        return $this->hot;
    }

    /**
     * Set original
     *
     * @param integer $original
     *
     * @return News
     */
    public function setOriginal($original)
    {
        $this->original = $original;

        return $this;
    }

    /**
     * Get original
     *
     * @return integer
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * Set reviewed
     *
     * @param integer $reviewed
     *
     * @return News
     */
    public function setReviewed($reviewed)
    {
        $this->reviewed = $reviewed;

        return $this;
    }

    /**
     * Get reviewed
     *
     * @return integer
     */
    public function getReviewed()
    {
        return $this->reviewed;
    }
}
