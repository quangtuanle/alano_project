<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Intl;

/**
 * Controller used to manage blog contents in the public part of the site.
 *
 * @Route("/blog")
 *
 */
class BlogController extends Controller
{
	/**
	 * @Route("/", name="blog_index", defaults={"page" = 1})
	 * @Route("/page/{page}", name="blog_index_paginated", requirements={"page" : "\d+"})
	 */
	public function indexAction($page)
	{
		$query = $this->getDoctrine()->getRepository('AppBundle:Post')->queryLastest();
		
		$paginator = $this->get('knp_paginator');
		$posts = $paginator->paginate($query, $page, Post::NUM_ITEMS);
		$posts->setUsedRoute('blog_index_paginated');
		
		return $this->render('blog/index.html.twig', array('posts' => $posts));
	}
	
	/**
	 * @Route("/posts/{slug}", name="blog_post")
	 *
	 * NOTE: The $post controller argument is automatically injected by Symfony
	 * after performing a database query looking for a Post with the
	 * 'slug' value given in the route.
	 * See http://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html
	 */
	public function commentNewAction(Request $request, Post $post)
	{
		
	}
	
	/**
	 * This controller is called directly via the render() function in the 
	 * blog/post_show.html.twig template. That's why it's not needed to define
	 * a route name for it 
	 *
	 * The "id" of the Post is passed in and then turned into a Post
	 * object automatically by the ParamConverter.
	 *
	 * @param Post $post
	 *
	 * @return Response
	 */
	public function commentFormAction(Post $post)
	{
		
	}
}


?>