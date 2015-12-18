<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Article;
use AppBundle\Entity\Account;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {		
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
	
	/**
	 * Chức năng: Load tất cả các bài viết lên content
	 * @Route("/alano", name = "show_article")
	 */
	public function showAction()
	{
		$posts = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findAll();
		
		return $this->render('alano/index.html.twig', array('posts' => $posts));
	}
	
	/**
	 * Chức năng: Tạo ra một bài viết mới
	 * @Route("/alano/new", name = "new_article")
	 */
	public function newAction(Request $request)
	{
		$account = new Account();
		$account = $this->getDoctrine()->getManager()->getRepository('AppBundle:Account')->findOneById(1);
		
		$article = new Article(); 
		$article->setPublishedAt(new \DateTime('today'));
		$article->setNumView(0);
		$article->setNumLike(0);
		$article->setNumUnlike(0);		
		$article->setNumShare(0);	
		$article->setAccount($account);
		
		$form = $this->createFormBuilder($article)
			->add('title', 'text')
			->add('summary', 'textarea')
			->add('content', 'textarea')
			
			->add('publishedAt', 'date')
			->add('tag', 'text')
			->add('specialTag', 'text')
			->add('create', 'submit', array('label' => 'Create News'))
			->getForm();
			
		$form->handleRequest($request);
		
		if ($form->isValid())
		{
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($article);
			$entityManager->flush();
			
			return $this->redirectToRoute('show_article');
		}
		
		return $this->render('default/new.html.twig', array('form' => 		$form->createView()));
	}
	
    /**
     * @Route("/posts/{id}", name="alano_post")
     *
     * NOTE: The $post controller argument is automatically injected by Symfony
     * after performing a database query looking for a Post with the 'slug'
     * value given in the route.
     * See http://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html
     */
    public function postShowAction(Article $post)
    {
        return $this->render('alano/post_show.html.twig', array('post' => $post));
    }	
}
