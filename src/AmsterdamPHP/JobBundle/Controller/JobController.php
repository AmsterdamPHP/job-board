<?php

namespace AmsterdamPHP\JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AmsterdamPHP\JobBundle\Entity\Job;
use AmsterdamPHP\JobBundle\Form\JobType;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use AmsterdamPHP\JobBundle\Form\ReportType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use AmsterdamPHP\JobBundle\Entity\JobRepository;
use AmsterdamPHP\JobBundle\EventListener\AbuseReportEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use AmsterdamPHP\JobBundle\Entity\JobRatingRepository;
use AmsterdamPHP\JobBundle\Entity\JobRating;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;

/**
 * Job controller.
 *
 */
class JobController extends Controller
{

    /**
     * list all jobes owned by user
     *
     * @return Response
     */
    public function ownAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        /** @var $repository JobRepository */
        $repository = $em->getRepository('AmsterdamPHPJobBundle:Job');
        $jobs = $repository->getJobByUser($user);

        return $this->render('AmsterdamPHPJobBundle:Job:own.html.twig', array(
            'entities' => $jobs,
        ));
    }
    /**
     * Lists all Job entities.
     *
     * @param integer $itemCount the number of entries to list
     * @param integer $offset    where to start
     *
     * @return Response
     */
    public function indexAction($itemCount = 10, $offset = 0)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var $repository JobRepository */
        $repository = $em->getRepository('AmsterdamPHPJobBundle:Job');
        $jobs = $repository->getJobsList($itemCount, $offset);

        return $this->render('AmsterdamPHPJobBundle:Job:index.html.twig', array(
            'entities' => $jobs,
        ));
    }

    public function searchRedirectAction(Request $request)
    {
        $query = $request->get('query');

        if (empty($query))
        {
            return $this->redirect($this->generateUrl('job'));
        }

        return $this->redirect($this->generateUrl('job_search', array('query' => $query)));
    }

    public function searchAction($query, $itemCount = 10, $offset = 0)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var $repository JobRepository */
        $repository = $em->getRepository('AmsterdamPHPJobBundle:Job');

        // TODO: Replace this with actual full-text searching
        $jobs = $repository->searchJobsByKeyword($query, $itemCount, $offset);

        return $this->render('AmsterdamPHPJobBundle:Job:index.html.twig', array(
            'entities' => $jobs,
        ));
    }

    /**
     * Creates a new Job entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Job();
        $form = $this->createForm(new JobType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $user = $this->get('security.context')->getToken()->getUser();
            $entity->setUser($user);

            $entity->setCreated(new \DateTime());

            $em->persist($entity);
            $em->flush();

            // creating the ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($entity);
            $acl = $aclProvider->createAcl($objectIdentity);

            // retrieving the security identity of the currently logged-in user
            $securityContext = $this->get('security.context');
            $securityIdentity = UserSecurityIdentity::fromAccount($user);

            // grant owner access
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);

            return $this->redirect($this->generateUrl('job_show', array('id' => $entity->getId())));
        }

        return $this->render('AmsterdamPHPJobBundle:Job:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Job entity.
     *
     */
    public function newAction()
    {
        $entity = new Job();
        $form   = $this->createForm(new JobType(), $entity);

        return $this->render('AmsterdamPHPJobBundle:Job:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Job entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var $entityRepository JobRepository */
        $entityRepository = $em->getRepository('AmsterdamPHPJobBundle:Job');
        $job = $entityRepository->getJobById($id);

        if ( ! $job) {
            throw $this->createNotFoundException('Unable to find Job.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $ratedJobs = json_decode($request->cookies->get('ratedJobs'));
        $ratedJob = is_array($ratedJobs) ? in_array($job->getId(), $ratedJobs) : false;

        return $this->render('AmsterdamPHPJobBundle:Job:show.html.twig', array(
            'entity'      => $job,
            'delete_form' => $deleteForm->createView(),
            'ratedJob'    => $ratedJob,
        ));
    }

    /**
     * Displays a form to edit an existing Job entity.
     *
     * @todo move security stuff out of here
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmsterdamPHPJobBundle:Job')->find($id);


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job.');
        }

         if (
            false === $this->get('security.context')->isGranted('OWNER', $entity) &&
            false === $this->get('security.context')->isGranted('ROLE_ADMIN')

            ) {
            throw new AccessDeniedException();
         }

        $editForm = $this->createForm(new JobType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AmsterdamPHPJobBundle:Job:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Job entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmsterdamPHPJobBundle:Job')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job.');
        }

        if (
            false === $this->get('security.context')->isGranted('OWNER', $entity) &&
            false === $this->get('security.context')->isGranted('ROLE_ADMIN')

            ) {
            throw new AccessDeniedException();
         }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new JobType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('job_edit', array('id' => $id)));
        }

        return $this->render('AmsterdamPHPJobBundle:Job:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Job entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AmsterdamPHPJobBundle:Job')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job.');
        }

        if (
            false === $this->get('security.context')->isGranted('OWNER', $entity) &&
            false === $this->get('security.context')->isGranted('ROLE_ADMIN')
        )
        {
            throw new AccessDeniedException();
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('job'));
    }

    /**
     * Creates a form to delete a Job entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    public function reportAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AmsterdamPHPJobBundle:Job')->find($id);

        $form = $this->createForm(new ReportType());

        return $this->render('AmsterdamPHPJobBundle:Job:report.html.twig', array(
            'form'   => $form->createView(),
            'entity' => $entity,
        ));
    }

    public function handleReportAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AmsterdamPHPJobBundle:Job')->find($id);

        $form = $this->createForm(new ReportType());
        $form->bind($request);

        if ( ! $form->isValid()) {
            return $this->render('AmsterdamPHPJobBundle:Job:report.html.twig', array(
                'form'   => $form->createView(),
                'entity' => $entity,
            ));
        }

        $data =$form->getData();
        $reason = $data['reason'];
        $name = $data['name'];
        $email = $data['email'];

        $abuseReportEvent = new AbuseReportEvent();
        $abuseReportEvent->setJob($entity);
        $abuseReportEvent->setName($name);
        $abuseReportEvent->setEmail($email);
        $abuseReportEvent->setReason($reason);

        /** @var $dispatcher EventDispatcher */
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch('send_abuse_report', $abuseReportEvent);

        return $this->redirect($this->generateUrl('job_show', array('id' => $id)));
    }

    public function handleRatingAction(Request $request, $id)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();
        /** @var $job Job */
        $job = $em->getRepository('AmsterdamPHPJobBundle:Job')->find($id);

        if ( ! $job) {
            throw $this->createNotFoundException('Unable to find Job.');
        }

        $rating = (float)$request->get('rating');

        $jobRating = new JobRating();
        $jobRating->setJob($job);
        $jobRating->setRating($rating);

        $em->persist($jobRating);
        $em->flush();

        return new Response((int)$job->getId(), 200);
    }
}
