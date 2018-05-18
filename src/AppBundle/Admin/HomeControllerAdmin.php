<?php

namespace AppBundle\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * DefaultAdmin controller.
 *
 * @Route("/")
 */
class HomeControllerAdmin extends Controller
{
    /**
     * @Route("/", name="homepage_admin")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Post')->findBy([], ['date' => 'desc'], 4);

        return $this->render('admin/home/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/tennis", name="tennis_admin")
     */
    public function tennisAction()
    {
        return $this->render('admin/home/tennis.html.twig');
    }

    /**
     * @Route("/snake", name="snake_admin")
     */
    public function snakeAction()
    {
        return $this->render('admin/home/snake.html.twig');
    }


}


