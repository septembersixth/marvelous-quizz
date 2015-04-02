<?php

namespace Application\Form;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SubscribeFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $formElementManager
     * @return Subscribe|mixed
     */
    public function createService(ServiceLocatorInterface $formElementManager)
    {
        $form = new Subscribe;
        $form->setInputFilter($formElementManager->getServiceLocator()
            ->get('InputFilterManager')
            ->get('Application\InputFilter\Subscribe')
        );

        $form
            ->setHydrator(new DoctrineObject($formElementManager->getServiceLocator()
                ->get('doctrine\ORM\EntityManager')))
            ->setObject(new Subscribe)
        ;

        return $form;
    }

} 