<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class Test extends EntityRepository
{
    public function getAllToArray()
    {
        $qb = $this->createQueryBuilder('test');
        $qb
            ->from('Application\Entity\Test', 't')
            ->where('t.deleted = false')
        ;

        $tests = $qb->getQuery()->getResult();
        $result = [];
        foreach($tests as $test) {
            $result[] = $test->toArray();
        }

        return $result;
    }
} 