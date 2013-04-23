<?php

namespace AmsterdamPHP\JobBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AmsterdamPHP\JobBundle\Entity\JobRating;

class JobRatingUpdater
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $rating = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ( ! ($rating instanceof JobRating))
            return;

        $job = $rating->getJob();
        $allRatings = $job->getRatings();

        if ( ! $allRatings)
            return;

        $totalRatings = $rating->getRating();
        $numberOfRatings = 1;

        foreach($allRatings as $rating)
        {
            $totalRatings += $rating->getRating();
            $numberOfRatings++;
        }

        $calculatedRating = $totalRatings / $numberOfRatings;

        $job->setCalculatedRating($calculatedRating);
        $entityManager->persist($job);
        $entityManager->flush();
    }
}
