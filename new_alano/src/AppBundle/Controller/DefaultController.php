<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
use AppBundle\Entity\User;

class DefaultController extends Controller
{
	/**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {		
		return $this->redirectToRoute("blog_index");
    }	
	
	/**
	 * @Route("/newsnew", name="news_index")
	 */
	public function getNewsAction(Request $request)
	{
        //$entityManager = $this->getDoctrine()->getManager();
        //$newses = $entityManager->getRepository('AppBundle:News')->findAll();

		$newses = $this->getDoctrine()->getManager()
			->createQuery('
				SELECT n 
				FROM AppBundle:News n 
				WHERE n.original = 1 
				ORDER BY n.hot DESC
			')->getResult();
		
        return $this->render('admin/blog/news.html.twig', array('newses' => $newses));
	}
}
