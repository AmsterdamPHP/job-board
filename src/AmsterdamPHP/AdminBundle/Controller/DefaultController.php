<?php

namespace AmsterdamPHP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AmsterdamPHPAdminBundle:Default:index.html.twig', array());
    }
}
