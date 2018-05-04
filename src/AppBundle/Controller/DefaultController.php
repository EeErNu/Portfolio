<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Post')->findBy([], ['date' => 'desc'], 4);


        return $this->render('frontend/default/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction()
    {
        return $this->render('frontend/default/contact.html.twig');
    }

    /**
     * @Route("/tennis", name="tennis")
     */
    public function tennisAction()
    {
        return $this->render('frontend/default/tennis.html.twig');
    }

    /**
     * @Route("/snake", name="snake")
     */
    public function snakeAction()
    {
        return $this->render('frontend/default/snake.html.twig');
    }


}


