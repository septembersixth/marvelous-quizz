<?php

namespace Administration\Form;

use Application\Entity\Post;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $formElementManager)
    {
        $form = new PostForm;
        $form->setInputFilter($formElementManager
                                ->getServiceLocator()
                                ->get('InputFilterManager')
                                ->get('Administration\InputFilter\PostInputFilter')
        );

        $form
            ->setHydrator(new DoctrineObject($formElementManager->getServiceLocator()->get('doctrine\ORM\EntityManager')))
            ->setObject(new Post)
        ;
        return $form;
    }

} 