<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Award;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Award controller.
 *
 * @Route("award")
 */
class AwardController extends Controller
{
    /**
     * Lists all award entities.
     *
     * @Route("/", name="award_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $awards = $em->getRepository('AppBundle:Award')->findAll();

        return $this->render('frontend/about/award/index.html.twig', array(
            'awards' => $awards,
        ));
    }

    /**
     * Finds and displays a award entity.
     *
     * @Route("/{id}", name="award_show")
     * @Method("GET")
     */
    public function showAction(Award $award)
    {
        return $this->render('frontend/about/award/show.html.twig', array(
            'award' => $award,
        ));
    }


}
