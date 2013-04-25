<?php

namespace AmsterdamPHP\JobBundle\EventListener;

use AmsterdamPHP\JobBundle\Entity\Job;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AmsterdamPHP\JobBundle\Entity\JobRating;

class JobRatingUpdater
{
    /**
     * Event listener which is triggered after a jobrating is persisted to the database.
     * It updates the calculated rating on the target job, which is just the average of all the ratings.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $rating = $args->getEntity();

        if ( ! ($rating instanceof JobRating))
            return;

        $job = $rating->getJob();
        $allRatings = $job->getRatings();

        if ( ! $allRatings)
            $allRatings = array();
        array_push($allRatings, $rating);

        $job = $this->updateJobWithNewRating($job, $allRatings);

        $entityManager = $args->getEntityManager();
        $this->saveJob($job, $entityManager);
    }

    /**
     * @param $job Job
     * @param $ratings JobRating[]
     * @return Job
     */
    protected function updateJobWithNewRating($job, $ratings)
    {
        $totalRatings = 0;
        $numberOfRatings = 0;

        foreach($ratings as $rating)
        {
            $totalRatings += $rating->getRating();
            $numberOfRatings++;
        }

        $calculatedRating = $totalRatings / $numberOfRatings;

        $job->setCalculatedRating($calculatedRating);

        return $job;
    }

    /**
     * @param $job Job
     * @param $entityManager EntityManager
     */
    protected function saveJob($job, $entityManager)
    {
        $entityManager->persist($job);
        $entityManager->flush();
    }
}
