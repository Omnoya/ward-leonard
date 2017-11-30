<?php

namespace WardLeonard\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class NewsController extends Controller
{
    /**
     * @Route("/", name="home_page")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('WardLeonardNewsBundle:News')->getNewsByOrderDesc();

        return $this->render('WardLeonardNewsBundle:Home:index.html.twig', array('news'=>$news));
    }
}
