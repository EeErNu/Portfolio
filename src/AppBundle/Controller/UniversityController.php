<?php

namespace AppBundle\Controller;

use AppBundle\Entity\University;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * University controller.
 *
 * @Route("university")
 */
class UniversityController extends Controller
{
    /**
     * Lists all university entities.
     *
     * @Route("/", name="university_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $universities = $em->getRepository('AppBundle:University')->findAll();

        return $this->render('frontend/about/university/index.html.twig', array(
            'universities' => $universities,
        ));
    }


    /**
     * Finds and displays a university entity.
     *
     * @Route("/{id}", name="university_show")
     * @Method("GET")
     */
    public function showAction(University $university)
    {

        return $this->render('frontend/about/university/show.html.twig', array(
            'university' => $university,
        ));
    }
}
