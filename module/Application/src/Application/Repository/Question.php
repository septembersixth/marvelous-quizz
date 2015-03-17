<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class Question extends EntityRepository
{
    /*
    public function getQuestionsByTestId($testId)
    {
        $qb = $this->createQueryBuilder('question');
        $expr = $qb->expr();
        $qb
            ->select('q')
            ->from('Application\Entity\Question', 'q')
            ->where('q.deleted = false')
            ->andWhere($expr->like('q.test.id', ':id'))
            ->setParameter('id', $testId)
        ;
        return $qb->getQuery()->getResult();
    }
    */
} 