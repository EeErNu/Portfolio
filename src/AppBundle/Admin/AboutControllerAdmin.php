<?php

namespace AppBundle\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * DefaultAdmin controller.
 *
 * @Route("/")
 */
class AboutControllerAdmin extends Controller
{
    /**
     * @Route("/about", name="about_admin")
     */
    public function aboutAction()
    {
        $em = $this->getDoctrine()->getManager();

        $companies = $em->getRepository('AppBundle:Company')->findAll();
        $universities = $em->getRepository('AppBundle:University')->findAll();
        $volunteers = $em->getRepository('AppBundle:Volunteer')->findAll();
        $awards = $em->getRepository('AppBundle:Award')->findAll();

        return $this->render('admin/about/about.html.twig', [
            'companies' => $companies,
            'universities' => $universities,
            'volunteers' => $volunteers,
            'awards' => $awards,
        ]);
    }
}


