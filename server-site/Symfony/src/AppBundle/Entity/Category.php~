<?php
// src/AppBundle/Entity/Category.php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=30)
	 */
	protected $nameCategory;
   
    /**
     * @ORM\OneToOne(
     *      targetEntity="DetailArticle",
     *      mappedBy="category",
     *      orphanRemoval=true
     * )
     */
	protected $detailArticle;		

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
     * Set nameCategory
     *
     * @param string $nameCategory
     *
     * @return Category
     */
    public function setNameCategory($nameCategory)
    {
        $this->nameCategory = $nameCategory;

        return $this;
    }

    /**
     * Get nameCategory
     *
     * @return string
     */
    public function getNameCategory()
    {
        return $this->nameCategory;
    }

    /**
     * Set detailArticle
     *
     * @param \AppBundle\Entity\DetailArticle $detailArticle
     *
     * @return Category
     */
    public function setDetailArticle(\AppBundle\Entity\DetailArticle $detailArticle = null)
    {
        $this->detailArticle = $detailArticle;

        return $this;
    }

    /**
     * Get detailArticle
     *
     * @return \AppBundle\Entity\DetailArticle
     */
    public function getDetailArticle()
    {
        return $this->detailArticle;
    }
}
