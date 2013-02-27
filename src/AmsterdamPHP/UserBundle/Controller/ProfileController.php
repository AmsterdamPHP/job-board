<?php

namespace AmsterdamPHP\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
    public function indexAction()
    {
        return $this->render('AmsterdamPHPUserBundle:Profile:index.html.twig');
    }
}
