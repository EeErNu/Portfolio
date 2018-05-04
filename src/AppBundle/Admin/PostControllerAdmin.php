<?php

namespace AppBundle\Admin;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;

/**
 * PostAdmin controller.
 *
 * @Route("/post")
 */
class PostControllerAdmin extends Controller
{
    /**
     * Lists all Post entities.
     *
     * @Route("/", name="post_index_admin")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('AppBundle:Post');

        $q = $request->query->getAlnum('filter');
        $query = $repo->searchPost($q);

//        $posts = $em->getRepository('AppBundle:Post')->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');
        $posts = $paginator ->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );

        return $this->render('admin/post/index.html.twig', [
            'posts' => $posts,
            'searchWord' => $q,
        ]);
    }

    /**
     * Creates a new Post entity.
     *
     * @Route("/new", name="post_new_admin")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm('AppBundle\Form\PostType', $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $post->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );
            $post->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $post->setDate(new \DateTime());
            $em->persist($post);
            $em->flush();

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('admin/post/new.html.twig', array(
            'post' => $post,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Post entity.
     *
     * @Route("/{id}", name="post_show_admin")
     * @Method("GET")
     */
    public function showAction(Post $post)
    {
        $deleteForm = $this->createDeleteForm($post);

        return $this->render('admin/post/show.html.twig', array(
            'post' => $post,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/{id}/edit", name="post_edit_admin")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Post $post)
    {
        if ($post->getImage()) {
            $post->setImage(new File($this->getParameter('image_directory').'/'.$post->getImage()));
        }

        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('AppBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $post->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );
            $post->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post_edit_admin', array('id' => $post->getId()));
        }

        return $this->render('admin/post/edit.html.twig', array(
            'post' => $post,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/{id}", name="post_delete_admin")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Post $post)
    {
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('post_index_admin');
    }

    /**
     * Creates a form to delete a Post entity.
     *
     * @param Post $post The Post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('post_delete_admin', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
