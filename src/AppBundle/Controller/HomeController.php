<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Post')->findBy([], ['date' => 'desc'], 4);


        return $this->render('frontend/home/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/tennis", name="tennis")
     */
    public function tennisAction()
    {
        return $this->render('frontend/home/tennis.html.twig');
    }

    /**
     * @Route("/snake", name="snake")
     */
    public function snakeAction()
    {
        return $this->render('frontend/home/snake.html.twig');
    }


}


