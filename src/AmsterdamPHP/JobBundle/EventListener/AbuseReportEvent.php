<?php

namespace AmsterdamPHP\JobBundle\EventListener;

use AmsterdamPHP\JobBundle\Entity\Job;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Templating\EngineInterface;

class AbuseReportEvent extends Event
{
    /**
     * @var string
     */
    private $reason;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $reporterName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var Job
     */
    private $job;

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param \AmsterdamPHP\JobBundle\Entity\Job $job
     */
    public function setJob($job)
    {
        $this->job = $job;
    }

    /**
     * @return \AmsterdamPHP\JobBundle\Entity\Job
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @return string
     */
    public function getReporterName()
    {
        return $this->reporterName;
    }

    /**
     * @param string $reporterName
     */
    public function setReporterName($reporterName)
    {
        $this->reporterName = $reporterName;
    }
}
