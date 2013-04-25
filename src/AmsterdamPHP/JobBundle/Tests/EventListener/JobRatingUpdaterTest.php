<?php

namespace AmsterdamPHP\JobBundle\Tests\EventListener;

use AmsterdamPHP\JobBundle\EventListener\JobRatingUpdater;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AmsterdamPHP\JobBundle\Entity\JobRating;
use AmsterdamPHP\JobBundle\Entity\Job;

class JobRatingUpdaterTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown() {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function postPersistForNewJob()
    {
        $entityManager = \Mockery::mock('\Doctrine\ORM\EntityManager');
        $entityManager->shouldReceive('persist')->with(\Mockery::on(function(Job $job) {
            return $job->getCalculatedRating() === 3;
        }))->once();
        $entityManager->shouldReceive('flush')->withNoArgs()->once();

        $job = new Job();
        $job->setId(1337);

        $newJobRating = new JobRating();
        $newJobRating->setJob($job);
        $newJobRating->setRating(3);

        $lifeCycleEventArgs = new LifecycleEventArgs($newJobRating, $entityManager);
        $jobRatingUpdater = new JobRatingUpdater();
        $jobRatingUpdater->postPersist($lifeCycleEventArgs);
    }

    /**
     * @test
     */
    public function postPersistWithExistingRatings()
    {
        $entityManager = \Mockery::mock('\Doctrine\ORM\EntityManager');
        $entityManager->shouldReceive('persist')->with(\Mockery::on(function(Job $job) {
            return $job->getCalculatedRating() === 3;
        }))->once();
        $entityManager->shouldReceive('flush')->withNoArgs()->once();

        $rating1 = new JobRating();
        $rating1->setRating(1);
        $rating2 = new JobRating();
        $rating2->setRating(3);

        $job = new Job();
        $job->setId(1337);
        $job->setRatings(array($rating1, $rating2));

        $newJobRating = new JobRating();
        $newJobRating->setJob($job);
        $newJobRating->setRating(5);

        $lifeCycleEventArgs = new LifecycleEventArgs($newJobRating, $entityManager);
        $jobRatingUpdater = new JobRatingUpdater();
        $jobRatingUpdater->postPersist($lifeCycleEventArgs);
    }
}
