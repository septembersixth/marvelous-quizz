<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Entity\Comment;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Paginator\Paginator;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineModule\Paginator\Adapter\Collection;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $em;

    public function indexAction()
    {
    }

    public function getEntityManager()
    {
        if (! $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

}
