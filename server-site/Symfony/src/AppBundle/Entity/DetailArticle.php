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
	private $id;	
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private $idArticle;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private $idCategory;

    /**
     * Set idArticle
     *
     * @param integer $idArticle
     *
     * @return DetailArticle
     */
    public function setIdArticle($idArticle)
    {
        $this->idArticle = $idArticle;

        return $this;
    }

    /**
     * Get idArticle
     *
     * @return integer
     */
    public function getIdArticle()
    {
        return $this->idArticle;
    }

    /**
     * Set idCategory
     *
     * @param integer $idCategory
     *
     * @return DetailArticle
     */
    public function setIdCategory($idCategory)
    {
        $this->idCategory = $idCategory;

        return $this;
    }

    /**
     * Get idCategory
     *
     * @return integer
     */
    public function getIdCategory()
    {
        return $this->idCategory;
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
