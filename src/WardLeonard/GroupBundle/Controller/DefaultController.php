<?php

namespace WardLeonard\GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class DefaultController
 * @package WardLeonard\GroupBundle\Controller
 * @Route("/admin")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/group", name="group_index")
     */
    public function indexAction()
    {
        return $this->render('WardLeonardGroupBundle:Default:index.html.twig');
    }
}
