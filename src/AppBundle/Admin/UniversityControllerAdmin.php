<?php

namespace AppBundle\Admin;

use AppBundle\Entity\University;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

/**
 * University controller.
 *
 * @Route("university")
 */
class UniversityControllerAdmin extends Controller
{
    /**
     * Lists all university entities.
     *
     * @Route("/", name="university_index_admin")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $universities = $em->getRepository('AppBundle:University')->findAll();

        return $this->render('admin/about/university/index.html.twig', array(
            'universities' => $universities,
        ));
    }

    /**
     * Creates a new university entity.
     *
     * @Route("/new", name="university_new_admin")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $university = new University();
        $form = $this->createForm('AppBundle\Form\UniversityType', $university);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($university);
            $em->flush();

            return $this->redirectToRoute('university_show_admin', array('id' => $university->getId()));
        }

        return $this->render('admin/about/university/new.html.twig', array(
            'university' => $university,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a university entity.
     *
     * @Route("/{id}", name="university_show_admin")
     * @Method("GET")
     */
    public function showAction(University $university)
    {
        $deleteForm = $this->createDeleteForm($university);

        return $this->render('admin/about/university/show.html.twig', array(
            'university' => $university,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing university entity.
     *
     * @Route("/{id}/edit", name="university_edit_admin")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, University $university)
    {
        if ($university->getImage()) {
            $university->setImage(new File($this->getParameter('image_directory').'/'.$university->getImage()));
        }

        $deleteForm = $this->createDeleteForm($university);
        $editForm = $this->createForm('AppBundle\Form\UniversityType', $university);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $file = $university->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );
            $university->setImage($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('university_edit_admin', array('id' => $university->getId()));
        }

        return $this->render('admin/about/university/edit.html.twig', array(
            'university' => $university,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a university entity.
     *
     * @Route("/{id}", name="university_delete_admin")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, University $university)
    {
        $form = $this->createDeleteForm($university);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $university->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );
            $university->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->remove($university);
            $em->flush();
        }

        return $this->redirectToRoute('about_admin');
    }

    /**
     * Creates a form to delete a university entity.
     *
     * @param University $university The university entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(University $university)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('university_delete_admin', array('id' => $university->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
