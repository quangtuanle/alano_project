<?php 

/**
 *
 */
 
namespace AppBundle\Controller\User;

use AppBundle\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Post;

/**
 * Controller used to manage blog contents in the backend.
 *
 * @Route("/user")
 * @Security("has_role('ROLE_USER')")
 *
 */
class BlogController extends Controller
{
	/**
	 * Lists all Post entities
	 *
     * @Route("/", name="user_index")
     * @Route("/", name="user_post_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        //$entityManager = $this->getDoctrine()->getManager();
        //$posts = $entityManager->getRepository('AppBundle:Post')->findAll();
		//$authorEmail = $this->getUser()->getEmail();
		//$posts = $this->getDoctrine()->getManager()
		//	->createQuery('
		//		SELECT p 
		//		FROM AppBundle:Post p 
		//		WHERE p.author_email = $authorEmail
		//		ORDER BY p.hot DESC
		//	')->getResult();
		$posts = $this->getDoctrine()->getRepository('AppBundle:Post')
			->findByAuthorEmail($this->getUser()->getEmail());
		//echo $this->getUser()->getEmail();
		
		// --- repair
        return $this->render('user/blog/index.html.twig', array('posts' => $posts));
    }
	
	/**
	 * Creates a new Post entity
	 *
	 * @Route("/new", name="user_post_new")
	 * @Method({"GET", "POST"})
	 *
	 */
	public function newAction(Request $request)
    {
        $post = new Post();
        $post->setAuthorEmail($this->getUser()->getEmail());

        // See http://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $form = $this->createForm(new PostType(), $post)
            ->add('saveAndCreateNew', 'submit');

        $form->handleRequest($request);

        // the isSubmitted() method is completely optional because the other
        // isValid() method already checks whether the form is submitted.
        // However, we explicitly add it to improve code readability.
        // See http://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setSlug($this->get('slugger')->slugify($post->getTitle()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See http://symfony.com/doc/current/book/controller.html#flash-messages
			/** SHOW INFO **/
            $this->addFlash('success', 'post.created_successfully');

            if ($form->get('saveAndCreateNew')->isClicked()) {
				// -- repair
                return $this->redirectToRoute('user_post_new');
            }

			// -- repair
            return $this->redirectToRoute('user_post_index');
        }

		// repair
        return $this->render('user/blog/new.html.twig', array(
            'post' => $post,
            'form' => $form->createView(),
        ));
    } 
	
	/**
     * Finds and displays a Post entity.
     *
     * @Route("/{id}", requirements={"id" = "\d+"}, name="user_post_show")
     * @Method("GET")
     */
    public function showAction(Post $post)
    {
        // This security check can also be performed:
        //   1. Using an annotation: @Security("post.isAuthor(user)")
        //   2. Using a "voter" (see http://symfony.com/doc/current/cookbook/security/voters_data_permission.html)
		
        if (null === $this->getUser() || !$post->isAuthor($this->getUser())) {
            throw $this->createAccessDeniedException('Posts can only be shown to their authors.');
        }

        $deleteForm = $this->createDeleteForm($post);

		// -- repair
        return $this->render('user/blog/show.html.twig', array(
            'post'        => $post,
            'delete_form' => $deleteForm->createView(),
        ));
    }
	
	/**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="user_post_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Post $post, Request $request)
    {
        if (null === $this->getUser() || !$post->isAuthor($this->getUser())) {
            throw $this->createAccessDeniedException('Posts can only be edited by their authors.');
        }

        $entityManager = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(new PostType(), $post);
        $deleteForm = $this->createDeleteForm($post);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $post->setSlug($this->get('slugger')->slugify($post->getTitle()));
            $entityManager->flush();

			// ?? 
            $this->addFlash('success', 'post.updated_successfully');

			// -- repair
            return $this->redirectToRoute('user_post_edit', array('id' => $post->getId()));
        }

		// -- repair
        return $this->render('user/blog/edit.html.twig', array(
            'post'        => $post,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/{id}", name="user_post_delete")
     * @Method("DELETE")
	 * /////////////////////////////////
     * @Security("post.isAuthor(user)")
     *
     * The Security annotation value is an expression (if it evaluates to false,
     * the authorization mechanism will prevent the user accessing this resource).
     * The isAuthor() method is defined in the AppBundle\Entity\Post entity.
     */
    public function deleteAction(Request $request, Post $post)
    {
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($post);
            $entityManager->flush();

            $this->addFlash('success', 'post.deleted_successfully');
        }

		// -- repair
        return $this->redirectToRoute('user_post_index');
    }

    /**
     * Creates a form to delete a Post entity by id.
     *
     * This is necessary because browsers don't support HTTP methods different
     * from GET and POST. Since the controller that removes the blog posts expects
     * a DELETE method, the trick is to create a simple form that *fakes* the
     * HTTP DELETE method.
     * See http://symfony.com/doc/current/cookbook/routing/method_parameters.html.
     *
     * @param Post $post The post object
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_post_delete', array('id' => $post->getId())))
            ->setMethod('DELETE') // ??
            ->getForm()
        ;
    }
}

?>