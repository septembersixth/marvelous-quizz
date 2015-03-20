<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class Test extends EntityRepository
{
    public function findAllToArray()
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->where('t.deleted = false')
        ;

        $tests = $qb->getQuery()->getResult();
        $result = [];
        foreach($tests as $test) {
            $result[] = $test->toArray();
        }

        return $result;
    }

    public function findQuestionById()
    {
//        $qb = $this->createQueryBuilder()
    }
} 