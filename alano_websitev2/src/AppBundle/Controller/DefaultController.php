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
		return $this->redirectToRoute("show_article");
    }
	
	/**
	 * Chức năng: Load tất cả các bài viết lên content
	 * @Route("/user", name = "show_article")
	 */
	public function showAction()
	{
		$posts = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findAll();
		$categories = $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findAll();
		
		return $this->render('user/index.html.twig', array('posts' => $posts, 'categories' => $categories));
	}
	
	/**
	 * Chức năng: Tạo ra một bài viết mới
	 * @Route("/user/new", name = "new_article")
	 */
	public function newAction(Request $request)
	{
		$user = new User();
		$user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findOneById(1);
		
		$article = new Article(); 
		$article->setPublishedAt(new \DateTime('today'));
		$article->setNumView(0);
		$article->setNumLike(0);
		$article->setNumUnlike(0);		
		$article->setNumShare(0);	
		$article->setUser($user);
		
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
		
		return $this->render('default/new.html.twig', array('form' => $form->createView()));
	}
	
    /**
     * @Route("/posts/{id}", name="user_post")
     *
     * NOTE: The $post controller argument is automatically injected by Symfony
     * after performing a database query looking for a Post with the 'slug'
     * value given in the route.
     * See http://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html
     */
    public function postShowAction(Article $post)
    {
		$categories = $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findAll();
		
        return $this->render('user/post_show.html.twig', array('post' => $post, 'categories' => $categories));
    }	
	
	/**
	* @Route("/admin")
	*/
	public function adminAction()
	{
		return new Response('<html><body>Admin page!</body></html>');
	}
	 
	/**
	 * @Route("/user")
	 */
	public function userAction()
	{
		return new Response('<html><body>User page!</body></html>');
	} 	
}
