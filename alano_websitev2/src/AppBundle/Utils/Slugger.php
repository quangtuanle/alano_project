<?php
namespace AppBundle\Utils;

/**
 * This class is used to provide an example of integrating simple
 * classes as services into a Symfony application
 */
class Slugger
{
	/**
	 * @param string $string 
	 *
	 * @return string
	 */
	public function slugify($string)
	{
		return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower(strip_tags($string))), '-');
	}
}

?>