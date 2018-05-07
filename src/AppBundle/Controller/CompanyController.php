<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Company controller.
 *
 * @Route("company")
 */
class CompanyController extends Controller
{
    /**
     * Lists all company entities.
     *
     * @Route("/", name="company_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $companies = $em->getRepository('AppBundle:Company')->findAll();

        return $this->render('frontend/about/company/index.html.twig', array(
            'companies' => $companies,
        ));
    }

    /**
     * Finds and displays a company entity.
     *
     * @Route("/{id}", name="company_show")
     * @Method("GET")
     */
    public function showAction(Company $company)
    {
        return $this->render('frontend/about/company/show.html.twig', array(
            'company' => $company,
        ));
    }
}
