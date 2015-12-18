<?php
// src/AppBundle/Entity/DetailArticle.php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="detailarticle")
 */
class DetailArticle
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;	
	
	/**
	 * ORM\Column(type="integer")
	 */
	//private $idArticle;
	
	/**
	 * ORM\Column(type="integer")
	 */
	//private $idCategory;
	
	/**
     * @ORM\OneToOne(
     *      targetEntity="Article",
     *      inversedBy="detailArticle"
     * )
	 * @ORM\JoinColumn(name="idArticle", referencedColumnName="id")
     */
    protected $article;		
	
	/**
     * @ORM\OneToOne(
     *      targetEntity="Category",
     *      inversedBy="detailArticle"
     * )
	 * @ORM\JoinColumn(name="idCategory", referencedColumnName="id")
     */
    protected $category;		

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
     * Set article
     *
     * @param \AppBundle\Entity\Article $article
     *
     * @return DetailArticle
     */
    public function setArticle(\AppBundle\Entity\Article $article = null)
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
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return DetailArticle
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
