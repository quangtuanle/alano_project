<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Controller used to manage the application security.
 * See http://symfony.com/doc/current/cookbook/security/form_login_setup.html.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login_form")
     */
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render('security/login.html.twig', array(
            // last username entered by the user (if any)
            'last_username' => $helper->getLastUsername(),
            // last authentication error (if any)
            'error' => $helper->getLastAuthenticationError(),
        ));
    }

    /**
     * This is the route the login form submits to.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the login automatically. See form_login in app/config/security.yml
     *
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {
        //throw new \Exception('This should never be reached!');
		
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			# User is a ROLE_ADMIN
			//return $this->redirectToRoute("admin_post_index");
			echo "This is Admin";
		}
		else if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
			echo "This is User";
		}
		else
		{
			echo "This is Unknown";
		}
		
		
		/*
		// if you're using Symfony 2.1 or greater
		// where "main" is the name of your firewall in security.yml
		$key = '_security.main.target_path';

		// try to redirect to the last page, or fallback to the homepage
		if ($this->container->get('session')->has($key)) {
			$url = $this->container->get('session')->get($key);
			$this->container->get('session')->remove($key);
		} 
		else {
			$url = $this->container->get('router')->generate('admin_post_index');
		}

		return new RedirectResponse($url);
		*/
	}

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in app/config/security.yml
     *
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('This should never be reached!');
    }
	
	/**
	 * @Route("/success", name="default_security_target")
	 */
	public function redirectSuccessAction()
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			# User is a ROLE_ADMIN
			return $this->redirectToRoute("admin_post_index");
			//echo "This is Admin";
		}
		//else if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
			//echo "This is User";
		//}
		else if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
			
			return $this->redirectToRoute("super_admin_post_index");
		}
		else if ($this->get('security.authorization_checker')->isGranted('ROLE_MEGA_ADMIN')) {
			
			return $this->redirectToRoute("mega_admin_post_index");
		}
		else
		{
			return $this->redirectToRoute("blog_index");
			//echo "This is Unknown";
		}
	}
}
