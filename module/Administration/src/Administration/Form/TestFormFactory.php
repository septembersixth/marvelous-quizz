<?php

namespace Administration\Form;

use Application\Entity\Test;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TestFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $formElementManager)
    {
        $form = new TestForm;
        $form->setInputFilter($formElementManager
                                ->getServiceLocator()
                                ->get('InputFilterManager')
                                ->get('Administration\InputFilter\TestInputFilter')
        );

        $form
            ->setHydrator(new DoctrineObject($formElementManager->getServiceLocator()->get('doctrine\ORM\EntityManager')))
            ->setObject(new Test)
        ;

        return $form;
    }

} 