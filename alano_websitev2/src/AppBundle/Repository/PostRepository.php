<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * This custom Doctrine repository contains some methods which are useful when
 * querying for blog post information.
 * See http://symfony.com/doc/current/book/doctrine.html#custom-repository-classes
 * 
 */
class PostRepository extends EntityRepository
{
	public function queryLatest()
	{
		return $this->getEntityManager()
			->createQuery('
				SELECT p
				FROM AppBundle:Post p
				WHERE p.publishedAt <= :now 
				ORDER BY p.publishedAt DESC
			')
			->setParameter('now', new \DateTime());
	}
	
	public function findLatest()
	{
		$this->queryLatest()->getResult();
	}
}

?>