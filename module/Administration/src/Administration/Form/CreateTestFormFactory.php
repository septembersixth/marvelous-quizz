<?php

namespace Administration\Form;

use Administration\Form\Fieldset\TestFieldset;
use Application\Entity\Test;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CreateTestFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $formElementManager)
    {
        $form = new TestFieldset;
        $form->setInputFilter($formElementManager
                                ->getServiceLocator()
                                ->get('InputFilterManager')
                                ->get('Administration\InputFilter\TestInputFilter')
        );

        return $form;
    }

} 