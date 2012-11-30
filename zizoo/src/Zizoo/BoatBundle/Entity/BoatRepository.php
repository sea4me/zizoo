<?php

namespace Zizoo\BoatBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BoatRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BoatRepository extends EntityRepository
{
    public function getBoats($limit = null)
    {
        $qb = $this->createQueryBuilder('b')
                   ->select('b')
                   ->addOrderBy('b.created', 'DESC');

        if (false === is_null($limit))
            $qb->setMaxResults($limit);

        return $qb->getQuery()
                  ->getResult();
    }   
}
