<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class Post extends EntityRepository
{
    public function getPostsByTagName($tagName)
    {
        $qb = $this->createQueryBuilder('post');
        $expr = $qb->expr();
        $qb
            ->select('p')
            ->from('Application\Entity\Post', 'p')
            ->leftJoin('p.tags', 't')
            ->where('p.deleted = false')
            ->andWhere($expr->like('t.name', ':name'))
            ->setParameter('name', $tagName)
        ;

        return $qb->getQuery()->getResult();
    }
} 