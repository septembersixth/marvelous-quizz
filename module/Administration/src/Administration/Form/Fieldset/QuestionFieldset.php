<?php

namespace Administration\Form\Fieldset;

use Application\Entity\Question;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use DoctrineModule\Stdlib\Hydrator\Strategy\DisallowRemoveByValue;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class QuestionFieldset extends Fieldset implements InputFilterProviderInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init()
    {
        $em = $this->getServiceLocator()->getServiceLocator()->get('doctrine\ORM\EntityManager');

        $hydrator = new DoctrineObject($em);

        $this
            ->setHydrator($hydrator)
            ->setObject(new Question)
        ;

        $this
            ->add([
                'name'  => 'id',
                'type'  => 'Hidden',
            ])

            ->add([
                'name'  => 'text',
                'type'  => 'text',
                'attributes' =>
                [
                    'class'         => 'form-control option-input question-text-input',
                    'placeholder'   => 'Enter question',
                ],
            ])
        ;

        $this->add([
            'type'    => 'Zend\Form\Element\Collection',
            'name'    => 'options',
            'options' => [
                'allow_add'                 => true,
                'allow_remove'              => true,
                'count'                     => 4,
                'template_placeholder'      => '__index-option__',
                'target_element'            => ['type' => 'Administration\Form\Fieldset\OptionFieldset' ],
            ],
            'attributes' => [
                'class' => 'optionFieldset',
            ],
        ]);
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return [
            'id' => [
                'required' => false,
            ],
            'text' => [
                'required' => true,
            ]
        ];
    }
}