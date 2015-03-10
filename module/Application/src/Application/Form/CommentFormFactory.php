<?php

namespace Application\Form;

use Application\Entity\Comment;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CommentFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $formElementManager)
    {
        $form = new CommentForm;
        $form->setInputFilter($formElementManager
                ->getServiceLocator()
                ->get('InputFilterManager')
                ->get('Application\InputFilter\CommentFilter')
        );

        $form
            ->setHydrator(new DoctrineObject($formElementManager->getServiceLocator()->get('doctrine\ORM\EntityManager')))
            ->setObject(new Comment)
        ;

        return $form;
    }

} 