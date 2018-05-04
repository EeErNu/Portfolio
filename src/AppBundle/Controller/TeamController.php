<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Team;
use AppBundle\Form\TeamType;

/**
 * Team controller.
 *
 * @Route("/team")
 */
class TeamController extends Controller
{
    /**
     * Lists all Team entities.
     *
     * @Route("/", name="team_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $teams = $em->getRepository('AppBundle:Team')->findAll();

        return $this->render('frontend/team/index.html.twig', array(
            'teams' => $teams,
        ));
    }

    /**
     * @Route("/table", name="table")
     */
    public function tableAction()
    {
        $em = $this->getDoctrine()->getManager();

        $teams = $em->getRepository('AppBundle:Team')->findAll();

        return $this->render('frontend/team/table.html.twig', array(
            'teams' => $teams,
        ));

    }
}
