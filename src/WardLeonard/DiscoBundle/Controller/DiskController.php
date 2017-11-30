<?php

namespace WardLeonard\DiscoBundle\Controller;

use WardLeonard\DiscoBundle\Entity\Disk;
use WardLeonard\DiscoBundle\Form\DiskType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

/**
 * Disk controller.
 *
 * @Route("admin")
 */
class DiskController extends Controller
{
    /**
     * Lists all disk entities.
     *
     * @Route("/disks", name="disk_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $disks = $em->getRepository('WardLeonardDiscoBundle:Disk')->findAll();

        return $this->render('WardLeonardDiscoBundle:disk:index.html.twig', array(
            'disks' => $disks,
        ));
    }

    /**
     * Creates a new disk entity.
     *
     * @Route("/disk/add", name="disk_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $disk = new Disk();
        $form = $this->createForm('WardLeonard\DiscoBundle\Form\DiskType', $disk, array(
            'attr' => array(
                'class' => 'form'
            )
        ))
        ->add('submit', SubmitType::class, array(
                'label' => 'form.disk.save'
            ))
        ->add('reset', ResetType::class, array(
                'label' => 'form.disk.reset'
            ));

        $form->handleRequest($request);

        if ($form->isSubmitted('POST') && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($disk);
            $em->flush();

            return $this->redirectToRoute('disk_show', array('id' => $disk->getId()));
        }

        return $this->render('WardLeonardDiscoBundle:disk:new.html.twig', array(
            'disk' => $disk,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a disk entity.
     *
     * @Route("/disk/show/{id}", name="disk_show")
     * @Method("GET")
     */
    public function showAction(Disk $disk)
    {
        $deleteForm = $this->createDeleteForm($disk);

        return $this->render('disk/show.html.twig', array(
            'disk' => $disk,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing disk entity.
     *
     * @Route("/disk/edit/{id}", name="disk_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Disk $disk)
    {
        $deleteForm = $this->createDeleteForm($disk);
        $editForm = $this->createForm('WardLeonard\DiscoBundle\Form\DiskType', $disk);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('disk_edit', array('id' => $disk->getId()));
        }

        return $this->render('WardLeonardDiscoBundle:disk:edit.html.twig', array(
            'disk' => $disk,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a disk entity.
     *
     * @Route("/disk/delete/{id}", name="disk_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Disk $disk)
    {
        $form = $this->createDeleteForm($disk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($disk);
            $em->flush();
        }

        return $this->redirectToRoute('disk_index');
    }

    /**
     * Creates a form to delete a disk entity.
     *
     * @param Disk $disk The disk entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Disk $disk)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('disk_delete', array('id' => $disk->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
