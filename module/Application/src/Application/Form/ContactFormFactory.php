<?php

namespace Application\Form;

use Application\Entity\Contact;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContactFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $formElementManager)
    {
        $form = new ContactForm;

        $form
            ->setObject(new Contact)
            ->setHydrator(new DoctrineObject($formElementManager->getServiceLocator()
                ->get('doctrine\ORM\EntityManager')))
        ;

        $form->setInputFilter((new Factory)->createInputFilter($form->getInputFilterConfig()));

        return $form;
    }

} 