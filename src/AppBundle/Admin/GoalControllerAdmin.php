<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Goal;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Goal controller.
 *
 * @Route("goal")
 */
class GoalControllerAdmin extends Controller
{
    /**
     * Lists all goal entities.
     *
     * @Route("/", name="goal_index_admin")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $goals = $em->getRepository('AppBundle:Goal')->findAll();

        $todos = $em->getRepository('AppBundle:Goal')->findBy(['done' => 'false']);
        $imps = $em->getRepository('AppBundle:Goal')->findBy(['done' => 'true']);

        return $this->render('admin/goal/index.html.twig', array(
            'goals' => $goals,
            'imps' => $imps,
            'todos' => $todos,
        ));
    }

    /**
     * Creates a new goal entity.
     *
     * @Route("/new", name="goal_new_admin")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $goal = new Goal();
        $form = $this->createForm('AppBundle\Form\GoalType', $goal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $goal->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );
            $goal->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($goal);
            $em->flush();

            return $this->redirectToRoute('goal_show_admin', array('id' => $goal->getId()));
        }

        return $this->render('admin/goal/new.html.twig', array(
            'goal' => $goal,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a goal entity.
     *
     * @Route("/{id}", name="goal_show_admin")
     * @Method("GET")
     */
    public function showAction(Goal $goal)
    {
        $deleteForm = $this->createDeleteForm($goal);

        return $this->render('admin/goal/show.html.twig', array(
            'goal' => $goal,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing goal entity.
     *
     * @Route("/{id}/edit", name="goal_edit_admin")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Goal $goal)
    {

        if ($goal->getImage()) {
            $goal->setImage(new File($this->getParameter('image_directory').'/'.$goal->getImage()));
        }

        $deleteForm = $this->createDeleteForm($goal);
        $editForm = $this->createForm('AppBundle\Form\GoalType', $goal);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $file = $goal->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );
            $goal->setImage($fileName);

            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('goal_edit_admin', array('id' => $goal->getId()));
        }

        return $this->render('admin/goal/edit.html.twig', array(
            'goal' => $goal,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a goal entity.
     *
     * @Route("/{id}", name="goal_delete_admin")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Goal $goal)
    {
        $form = $this->createDeleteForm($goal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($goal);
            $em->flush();
        }

        return $this->redirectToRoute('goal_index_admin');
    }

    /**
     * Creates a form to delete a goal entity.
     *
     * @param Goal $goal The goal entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Goal $goal)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('goal_delete_admin', array('id' => $goal->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
