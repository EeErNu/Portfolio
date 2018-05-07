<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Volunteer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Volunteer controller.
 *
 * @Route("volunteer")
 */
class VolunteerController extends Controller
{
    /**
     * Lists all volunteer entities.
     *
     * @Route("/", name="volunteer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $volunteers = $em->getRepository('AppBundle:Volunteer')->findAll();

        return $this->render('frontend/about/volunteer/index.html.twig', array(
            'volunteers' => $volunteers,
        ));
    }

    /**
     * Finds and displays a volunteer entity.
     *
     * @Route("/{id}", name="volunteer_show")
     * @Method("GET")
     */
    public function showAction(Volunteer $volunteer)
    {

        return $this->render('frontend/about/volunteer/show.html.twig', array(
            'volunteer' => $volunteer
        ));
    }
}
