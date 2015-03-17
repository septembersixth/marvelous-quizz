<?php

namespace Administration\Form;

use Application\Entity\Question;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QuestionFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $formElementManager)
    {
        $form = new QuestionForm;
        $form->setInputFilter($formElementManager
                                ->getServiceLocator()
                                ->get('InputFilterManager')
                                ->get('Administration\InputFilter\QuestionInputFilter')
        );

        $form
            ->setHydrator(new DoctrineObject($formElementManager->getServiceLocator()->get('doctrine\ORM\EntityManager')))
            ->setObject(new Question)
        ;

        return $form;
    }

} 