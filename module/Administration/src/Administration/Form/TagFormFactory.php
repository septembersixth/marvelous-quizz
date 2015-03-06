<?php

namespace Administration\Form;

use Application\Entity\Tag;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TagFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $formElementManager)
    {
        $form = new TagForm;
        $form->setInputFilter($formElementManager
                                ->getServiceLocator()
                                ->get('InputFilterManager')
                                ->get('Administration\InputFilter\TagInputFilter')
        );

        $form
            ->setHydrator(new DoctrineObject($formElementManager->getServiceLocator()->get('doctrine\ORM\EntityManager')))
            ->setObject(new Tag)
        ;

        return $form;
    }

} 