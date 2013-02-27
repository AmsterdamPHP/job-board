<?php

namespace AmsterdamPHP\JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AmsterdamPHPJobBundle:Default:index.html.twig', array('name' => $name));
    }
}
