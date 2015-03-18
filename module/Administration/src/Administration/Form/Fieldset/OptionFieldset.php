<?php

namespace Administration\Form\Fieldset;

use Application\Entity\Option;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use DoctrineModule\Stdlib\Hydrator\Strategy\DisallowRemoveByValue;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class OptionFieldset extends Fieldset implements InputFilterProviderInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init()
    {
        $em = $this->getServiceLocator()->getServiceLocator()->get('doctrine\ORM\EntityManager');
        $this
            ->setHydrator(new DoctrineObject($em))
            ->setObject(new Option)
        ;

        $this
            ->add([
                'name'          => 'id',
                'type'          => 'Hidden',
                'attributes'    => [
                    'class'     => 'option-input',
                ]
            ])

            ->add([
                'name'  => 'text',
                'type'  => 'text',
                'attributes' =>
                [
                    'class'         => 'option-input',
                    'placeholder'   => 'Enter answer',
                ],
            ])

            ->add([
                'name'      => 'correct',
                'type'      => 'Checkbox',
                'options'   =>
                [
                    'label'                 => 'correct',
                    'use_hidden_element'    => false,
                    'checked_value'         => '1',
                ],
                'attributes'    => [
                    'class'     => 'option-input',
                ]
            ])
        ;
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
            ],
            'correct' => [
                'required' => false,
            ]
        ];
    }
}