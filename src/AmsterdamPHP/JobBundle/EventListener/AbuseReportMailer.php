<?php

namespace AmsterdamPHP\JobBundle\EventListener;

use Swift_Mailer;
use Symfony\Component\Templating\EngineInterface;

class AbuseReportMailer
{
    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    private $templating;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $abuseReportEmailAddress;

    public function __construct(EngineInterface $templating, Swift_Mailer $mailer, $abuseReportEmailAddress)
    {
        $this->templating = $templating;
        $this->mailer = $mailer;
        $this->abuseReportEmailAddress = $abuseReportEmailAddress;
    }

    public function onEvent(AbuseReportEvent $event)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Job abuse report')
            ->setFrom('abuse@amsterdamphp.nl', 'AmsterdamPHP Job Board')
            ->setTo($this->abuseReportEmailAddress)
            ->setBody(
                $this->templating->render(
                    'AmsterdamPHPJobBundle:Report:report.txt.twig',
                    array(
                        'job'         => $event->getJob(),
                        'reason'      => $event->getReason(),
                        'description' => $event->getDescription(),
                        'name'        => $event->getReporterName(),
                        'email'       => $event->getEmail(),
                    )
                )
            )
        ;

        $this->mailer->send($message);
    }
}
