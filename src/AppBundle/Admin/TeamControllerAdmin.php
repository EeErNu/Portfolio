<?php

namespace AppBundle\Admin;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Team;
use AppBundle\Form\TeamType;

/**
 * TeamAdmin controller.
 *
 * @Route("/team")
 */
class TeamControllerAdmin extends Controller
{
    /**
     * Lists all Team entities.
     *
     * @Route("/", name="team_index_admin")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $teams = $em->getRepository('AppBundle:Team')->findAll();

        return $this->render('admin/team/index.html.twig', array(
            'teams' => $teams,
        ));
    }

    /**
     * @Route("/table", name="table_index_admin")
     */
    public function tableAction()
    {
        $em = $this->getDoctrine()->getManager();

        $teams = $em->getRepository('AppBundle:Team')->findAll();

        return $this->render('admin/team/table.html.twig', array(
            'teams' => $teams,
        ));

    }

    /**
     * Creates a new Team entity.
     *
     * @Route("/new", name="team_new_admin")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $team = new Team();
        $form = $this->createForm('AppBundle\Form\TeamType', $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('team_show', array('id' => $team->getId()));
        }

        return $this->render('admin/team/new.html.twig', array(
            'team' => $team,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Team entity.
     *
     * @Route("/{id}", name="team_show_admin")
     * @Method("GET")
     */
    public function showAction(Team $team)
    {
        $deleteForm = $this->createDeleteForm($team);

        return $this->render('admin/team/show.html.twig', array(
            'team' => $team,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Team entity.
     *
     * @Route("/{id}/edit", name="team_edit_admin")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Team $team)
    {
        if ($team->getImage()) {
            $team->setImage(new File($this->getParameter('image_directory').'/'.$team->getImage()));
        }

        $deleteForm = $this->createDeleteForm($team);
        $editForm = $this->createForm('AppBundle\Form\TeamType', $team);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('team_edit_admin', array('id' => $team->getId()));
        }

        return $this->render('admin/team/edit.html.twig', array(
            'team' => $team,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Team entity.
     *
     * @Route("/{id}", name="team_delete_admin")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Team $team)
    {
        $form = $this->createDeleteForm($team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($team);
            $em->flush();
        }

        return $this->redirectToRoute('team_index_admin');
    }

    /**
     * Creates a form to delete a Team entity.
     *
     * @param Team $team The Team entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Team $team)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('team_delete_admin', array('id' => $team->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
