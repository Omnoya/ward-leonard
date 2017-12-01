<?php

namespace WardLeonard\DiscoBundle\Controller;

use WardLeonard\DiscoBundle\Entity\Lyric;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Lyric controller.
 *
 * @Route("/admin")
 */
class LyricController extends Controller
{
    /**
     * Lists all lyric entities.
     *
     * @Route("/lyrics", name="lyric_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lyrics = $em->getRepository('WardLeonardDiscoBundle:Lyric')->findAll();

        return $this->render('lyric/index.html.twig', array(
            'lyrics' => $lyrics,
        ));
    }

    /**
     * Creates a new lyric entity.
     *
     * @Route("/lyric/new", name="lyric_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $lyric = new Lyric();
        $form = $this->createForm('WardLeonard\DiscoBundle\Form\LyricType', $lyric);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lyric);
            $em->flush();

            return $this->redirectToRoute('lyric_show', array('id' => $lyric->getId()));
        }

        return $this->render('lyric/new.html.twig', array(
            'lyric' => $lyric,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a lyric entity.
     *
     * @Route("/lyric/show/{id}", name="lyric_show")
     * @Method("GET")
     */
    public function showAction(Lyric $lyric)
    {
        $deleteForm = $this->createDeleteForm($lyric);

        return $this->render('lyric/show.html.twig', array(
            'lyric' => $lyric,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing lyric entity.
     *
     * @Route("/lyric/edit/{id}", name="lyric_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Lyric $lyric)
    {
        $deleteForm = $this->createDeleteForm($lyric);
        $editForm = $this->createForm('WardLeonard\DiscoBundle\Form\LyricType', $lyric);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lyric_edit', array('id' => $lyric->getId()));
        }

        return $this->render('lyric/edit.html.twig', array(
            'lyric' => $lyric,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a lyric entity.
     *
     * @Route("/lyric/delete/{id}", name="lyric_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lyric $lyric)
    {
        $form = $this->createDeleteForm($lyric);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lyric);
            $em->flush();
        }

        return $this->redirectToRoute('lyric_index');
    }

    /**
     * Creates a form to delete a lyric entity.
     *
     * @param Lyric $lyric The lyric entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Lyric $lyric)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lyric_delete', array('id' => $lyric->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
