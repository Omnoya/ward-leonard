<?php

namespace WardLeonard\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use WardLeonard\NewsBundle\Entity\News;
use WardLeonard\NewsBundle\Form\NewsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class BackController
 * @package WardLeonard\NewsBundle\Controller
 * @Route("/admin")
 * @Security("has_role('ROLE_ADMIN')")
 */
class BackController extends Controller
{
    /**
     * @Route("/news", name="news_index")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository("WardLeonardNewsBundle:News");
        $news = $repository->findAll();

        return $this->render('WardLeonardNewsBundle:Back:index.html.twig', array('news' => $news));
    }

    /**
     * @Route("/news/show/{id}", name="news_show")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('WardLeonardNewsBundle:News')->find($id);

        if (!is_null($news)) {
            return $this->render('WardLeonardNewsBundle:Back:show.html.twig', array('news' => $news));
        } else {
            return $this->redirect($this->generateUrl('news_index'));
        }


    }

    /**
     * @Route("/news/add", name="news_new")
     * @Template
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request){
        $form = $this->createForm(NewsType::class, new News(), array(
              'attr' => array(
                  'class' => 'form'
              )
        ))
            ->add('submit', SubmitType::class, array(
                'label' => 'form.news.save'
            ))
            ->add('reset', ResetType::class, array(
                'label' => 'form.news.reset'
            ));

        $form->handleRequest($request);

        if($request->isMethod('POST') && $form->isValid())
        {
            $session = new Session();
            $session->getFlashBag()->add('notice', 'Bravo : News enregistrée');

            $em =$this->getDoctrine()->getManager();

            $news = $form->getData();
            $filePhoto = $form['photo']->getData();

            if (!is_null($filePhoto)) {
                $news->setPhoto($filePhoto->getClientOriginalName());
                $filePhoto->move($this->getParameter('image_path'), $filePhoto->getClientOriginalName());
            }

            $em->persist($news);
            $em->flush();

            //$this->redirect($this->generateUrl('back_news_add'));

            return $this->redirectToRoute('news_index');
        }

         return array('form_add' => $form->createView(), 'titre' => 'Ajouter une news');
         // redirige vers add.html.twig qui récupère form_add
    }

    /**
     * @Route("/news/modify/{id}", name="news_modify")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifyAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('WardLeonardNewsBundle:News')->find($id);

        $form = $this->createForm(NewsType::class, $news, array(

        ))
            ->add('submit', SubmitType::class, array(
                'label' => 'form.news.save'
            ))
            ->add('reset', ResetType::class, array(
                'label' => 'form.news.reset'
            ));

        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isValid()) {
            $news = $form->getData();
            $filePhoto = $form['photo']->getData();

            if (!is_null($filePhoto)) {
                $news->setPhoto($filePhoto->getClientOriginalName());
                $filePhoto->move($this->getParameter('image_path'), $filePhoto->getClientOriginalName());
            }

            $em->persist($news);
            $em->flush();

            return $this->redirect($this->generateUrl('news_index'));
        }
        return $this->render('WardLeonardNewsBundle:Back:add.html.twig', array(
            'form_add' => $form->createView(),
            'titre' => "Modification d'une news"));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/news/delete/{id}", name="news_delete")
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("WardLeonardNewsBundle:News");

        $news = $repository->find($id);

        if($news !==null ) {
            $em->remove($news);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('news_index'));
    }
}
