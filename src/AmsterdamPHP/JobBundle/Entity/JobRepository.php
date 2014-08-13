<?php

namespace AmsterdamPHP\JobBundle\Entity;

use Doctrine\ORM\EntityRepository;
use AmsterdamPHP\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints\DateTime;

class JobRepository extends EntityRepository
{

    /**
     * @param $id
     * @return Job
     */
    public function getJobById($id)
    {
        $entity = $this->find($id);
        return $entity;
    }

    /**
     * @param \AmsterdamPHP\UserBundle\Entity\User $user
     * @return Job[]
     */
    public function getJobsByUser(User $user)
    {
        $queryBuilder = $this->createQueryBuilder('job');
        $query = $queryBuilder
            ->where('job.user = :user')
            ->andWhere('job.blocked = 0')
            ->andWhere('job.archived = 0')
            ->orderBy('job.id', 'desc')
            ->getQuery()
            ->setParameter('user', $user);

        $jobs = $query->getResult();

        return $jobs;
    }

    /**
     * @param int $itemCount
     * @param int $offset
     * @return Job[]
     */
    public function getJobsList($itemCount = 10, $offset = 0)
    {
        $queryBuilder = $this->createQueryBuilder('job');
        $query = $queryBuilder
            ->where('job.blocked = 0')
            ->andWhere('job.archived = 0')
            ->andWhere('job.expires >= :now')
            ->setParameter('now', new DateTime())
            ->setMaxResults($itemCount)
            ->setFirstResult($offset)
            ->getQuery();

        $entities = $query->getResult();
        return $entities;
    }

    /**
     * @param $keyword
     * @param int $itemCount
     * @param int $offset
     * @return Job[]
     */
    public function searchJobsByKeyword($keyword, $itemCount = 10, $offset = 0)
    {
        $queryBuilder = $this->createQueryBuilder('job');
        $query = $queryBuilder
            ->where($queryBuilder->expr()->like('job.title', ':query'))
            ->orWhere($queryBuilder->expr()->like('job.description', ':query'))
            ->setParameter('query', "%$keyword%")
            ->orderBy('job.id', 'desc')
            ->setFirstResult($offset)
            ->setMaxResults($itemCount)
            ->getQuery();

        $jobs = $query->getResult();

        return $jobs;
    }
}
