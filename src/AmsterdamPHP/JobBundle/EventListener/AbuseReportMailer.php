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

    public function __construct(EngineInterface $templating, Swift_Mailer $mailer)
    {
        $this->templating = $templating;
        $this->mailer = $mailer;
    }

    public function onEvent(AbuseReportEvent $event)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Job abuse report')
            ->setFrom('abuse@amsterdamphp.nl')
            ->setTo('pascal.de.vink@gmail.com')
            ->setBody(
                $this->templating->render(
                    'AmsterdamPHPJobBundle:Job:report.txt.twig',
                    array(
                        'job'       => $event->getJob(),
                        'reason'    => $event->getReason(),
                        'name'      => $event->getName(),
                        'email'     => $event->getEmail(),
                    )
                )
            )
        ;

        $this->mailer->send($message);
    }
}
