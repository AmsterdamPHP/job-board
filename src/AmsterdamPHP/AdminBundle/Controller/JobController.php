<?php

namespace AmsterdamPHP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityRepository;
use AmsterdamPHP\JobBundle\Entity\Job;
use Doctrine\ORM\EntityManager;

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

    public function archiveAction($id)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();
        $entity = $this->getJobById($em, $id);

        $entity->setArchived(true);
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_jobs'));
    }

    public function blockAction($id)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();
        $entity = $this->getJobById($em, $id);

        $entity->setBlocked(true);
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_jobs'));
    }

    /**
     * @param \Doctrine\ORM\EntityManager $em
     * @param $id
     * @return Job
     */
    protected function getJobById(EntityManager $em, $id)
    {
        /** @var $repository EntityRepository */
        $repository = $em->getRepository('AmsterdamPHPJobBundle:Job');

        $criteria = array('id' => $id);
        /** @var $entity Job */
        $entity = $repository->findOneBy($criteria);

        return $entity;
    }
}
