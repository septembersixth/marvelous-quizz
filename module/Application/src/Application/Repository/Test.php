<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class Test extends EntityRepository
{
    public function findToArray($limit)
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->where('t.deleted = false')
            ->setMaxResults($limit)
        ;

        $tests = $qb->getQuery()->getResult();
        $result = [];
        foreach($tests as $test) {
            $result[] = $test->toArray();
        }

        return $result;
    }

    /*
    public function findRandom($limit)
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->where('t.deleted = false');
        ;
    }
    */
} 