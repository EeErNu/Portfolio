<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Award;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Award controller.
 *
 * @Route("award")
 */
class AwardControllerAdmin extends Controller
{
    /**
     * Lists all award entities.
     *
     * @Route("/", name="award_index_admin")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $awards = $em->getRepository('AppBundle:Award')->findAll();

        return $this->render('admin/about/award/index.html.twig', array(
            'awards' => $awards,
        ));
    }

    /**
     * Creates a new award entity.
     *
     * @Route("/new", name="award_new_admin")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $award = new Award();
        $form = $this->createForm('AppBundle\Form\AwardType', $award);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($award);
            $em->flush();

            return $this->redirectToRoute('award_show_admin', array('id' => $award->getId()));
        }

        return $this->render('admin/about/award/new.html.twig', array(
            'award' => $award,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a award entity.
     *
     * @Route("/{id}", name="award_show_admin")
     * @Method("GET")
     */
    public function showAction(Award $award)
    {
        $deleteForm = $this->createDeleteForm($award);

        return $this->render('admin/about/award/show.html.twig', array(
            'award' => $award,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing award entity.
     *
     * @Route("/{id}/edit", name="award_edit_admin")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Award $award)
    {
        $deleteForm = $this->createDeleteForm($award);
        $editForm = $this->createForm('AppBundle\Form\AwardType', $award);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin/about/award_edit_admin', array('id' => $award->getId()));
        }

        return $this->render('admin/about/award/edit.html.twig', array(
            'award' => $award,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a award entity.
     *
     * @Route("/{id}", name="award_delete_admin")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Award $award)
    {
        $form = $this->createDeleteForm($award);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($award);
            $em->flush();
        }

        return $this->redirectToRoute('about_admin');
    }

    /**
     * Creates a form to delete a award entity.
     *
     * @param Award $award The award entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Award $award)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('award_delete_admin', array('id' => $award->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
