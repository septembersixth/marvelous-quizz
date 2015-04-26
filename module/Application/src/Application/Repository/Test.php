<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class Test extends EntityRepository
{
    /**
     * @param $limit
     * @return array
     * find random tests
     */
    public function findRandomToArray($limit)
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->where('t.deleted = false')
            ->select('t.id')
        ;
        $tests = $qb->getQuery()->getResult();
        array_walk($tests, function(&$val){
            $val = $val['id'];
        });

        $limit = count($tests) < $limit ? count($tests) : $limit;
        $tests = array_rand(array_flip($tests), $limit);

        $qb = $this->createQueryBuilder('t');
        $qb
            ->where($qb->expr()->in('t.id', ':tests'))
            ->setParameter('tests', $tests)
        ;
        $tests = $qb->getQuery()->getResult();
        shuffle($tests);
        $result = [];
        foreach($tests as $test) {
            $result[] = $test->toArray();
        }

        return $result;
    }
}