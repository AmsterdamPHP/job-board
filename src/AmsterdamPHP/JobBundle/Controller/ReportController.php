<?php

namespace AmsterdamPHP\JobBundle\Controller;

use AmsterdamPHP\JobBundle\Form\ChoiceList\ReportViolation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AmsterdamPHP\JobBundle\Entity\Job;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use AmsterdamPHP\JobBundle\Form\ReportType;
use Symfony\Component\HttpFoundation\Request;
use AmsterdamPHP\JobBundle\EventListener\AbuseReportEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use AmsterdamPHP\JobBundle\Entity\JobRating;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;

/**
 * Job controller.
 *
 */
class ReportController extends Controller
{
    public function reportAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AmsterdamPHPJobBundle:Job')->find($id);

        $form = $this->createForm(new ReportType());

        return $this->render('AmsterdamPHPJobBundle:Report:report.html.twig', array(
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
            return $this->render('AmsterdamPHPJobBundle:Report:report.html.twig', array(
                'form'   => $form->createView(),
                'entity' => $entity,
            ));
        }

        $reportChoices = new ReportViolation();

        $data = $form->getData();
        $reason = $reportChoices->getLabelForOption($data['reason']);
        $description = $data['description'];
        $name = $data['name'];
        $email = $data['email'];

        $abuseReportEvent = new AbuseReportEvent();
        $abuseReportEvent->setJob($entity);
        $abuseReportEvent->setReporterName($name);
        $abuseReportEvent->setEmail($email);
        $abuseReportEvent->setReason($reason);
        $abuseReportEvent->setDescription($description);

        /** @var $dispatcher EventDispatcher */
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch('send_abuse_report', $abuseReportEvent);

        return $this->redirect($this->generateUrl('job_show', array('id' => $id)));
    }
}
