<?php

namespace Application\Controller;

use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class JsonController extends AbstractActionController
{
    protected $em;

    public function testsAction()
    {
        $testRepository = $this->getEntityManager()->getRepository('Application\Entity\Test');

        return  new JsonModel($testRepository->findAllToArray());
    }

    public function getEntityManager()
    {
        if (! $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine\ORM\EntityManager');
        }

        return $this->em;
    }
} 