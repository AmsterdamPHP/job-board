<?php

namespace AmsterdamPHP\JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AmsterdamPHPJobBundle:Default:index.html.twig', array('name' => $name));
    }

    public function googleAnalyticsAction()
    {
        $googleAnalyticsUACode = $this->container->getParameter('google_analytics_ua_code');
        $googleAnalyticsUrl = $this->container->getParameter('google_analytics_url');

        return $this->render('AmsterdamPHPJobBundle:Default:ga.html.twig', array(
            'googleAnalyticsUACode' => $googleAnalyticsUACode,
            'googleAnalyticsUrl' => $googleAnalyticsUrl,
        ));
    }
}
