<?php

namespace AmsterdamPHP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class JobController extends Controller
{
    public function listAction($itemCount = 10, $offset = 0)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = array();
        $orderBy = array('id'=>'desc');

        $entities = $em->getRepository('AmsterdamPHPJobBundle:Job')->findBy($criteria, $orderBy, $itemCount, $offset);

        return $this->render('AmsterdamPHPAdminBundle:Job:index.html.twig', array(
            'entities' => $entities,
        ));
    }
}
