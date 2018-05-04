<?php

namespace AppBundle\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * DefaultAdmin controller.
 *
 * @Route("/")
 */
class DefaultControllerAdmin extends Controller
{
    /**
     * @Route("/", name="homepage_admin")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Post')->findBy([], ['date' => 'desc'], 4);


        return $this->render('admin/default/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/contact", name="contact_admin")
     */
    public function contactAction()
    {
        return $this->render('admin/default/contact.html.twig');
    }

    /**
     * @Route("/tennis", name="tennis_admin")
     */
    public function tennisAction()
    {
        return $this->render('admin/default/tennis.html.twig');
    }

    /**
     * @Route("/snake", name="snake_admin")
     */
    public function snakeAction()
    {
        return $this->render('admin/default/snake.html.twig');
    }


}


