<?php

namespace Administration\Form\Fieldset;

use Application\Entity\Test;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use DoctrineModule\Stdlib\Hydrator\Strategy\DisallowRemoveByValue;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class TestFieldset extends Fieldset implements InputFilterProviderInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init()
    {
        $this->setName('test');
        $em = $this->getServiceLocator()->getServiceLocator()->get('doctrine\ORM\EntityManager');

        $hydrator = new DoctrineObject($em);

        $this
            ->setHydrator($hydrator)
            ->setObject(new Test)
        ;



        $this
            ->add([
                'name'  => 'id',
                'type'  => 'Hidden',
            ])

            ->add([
                'name'  => 'hash',
                'type'  => 'text',
            ])

            ->add([
                'name'  => 'image',
                'type'  => 'File',
            ])


            ->add([
                'name'  => 'explanation',
                'type'  => 'textarea',
                'attributes' =>
                    [
                        'class'         => 'form-control',
                        'placeholder'   => 'Enter content',
                        'rows'          => '8',
                    ],
            ])

            ->add([
                'type'      => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
                'name'      => 'tags',
                'options'   =>
                    [
                        'object_manager'    => $em,
                        'target_class'      => 'Application\Entity\Tag',
                        'property'          => 'name',
                        'find_method'       =>
                            [
                                'name'          => 'findBy',
                                'params'        => [
                                    'criteria'  => ['deleted' => false],
                                ],
                            ],

                        'label_attributes'  =>
                            [
                                'class' => 'checkbox-inline'
                            ]
                    ],
            ])
        ;

            $this->add([
                'type'    => 'Zend\Form\Element\Collection',
                'name'    => 'questions',
                'options' => [
                    'should_create_template'    => true,
                    'allow_add'                 => true,
                    'allow_remove'              => true,
                    'count'                     => 1,
                    'template_placeholder'      => '__index-question__',
                    'target_element'            => ['type' => 'Administration\Form\Fieldset\QuestionFieldset' ],
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

            'hash' => [
                'required' => false,
            ],

            'tags' => [
                'required' => false,
            ],

            'explanation' => [
                'required'      => true,
                'filters'       => [['name' => 'StringTrim']],
            ],

            'image' =>
            [
                'type' => 'Zend\InputFilter\FileInput',
                'required'      => false,
                'filters'       =>
                [
                    [
                        'name' => 'File\RenameUpload',
                        'options' =>
                        [
                            'target'    => 'data/upload',
                            'randomize' => true,
                        ]
                    ]
                ],
                'validators'     =>
                [
                    [
                        'name'      => 'File\Size',
                        'options'   => ['max' => '2MB'],
                    ],
                    [
                        'name'      => 'File\Extension',
                        'options'   => ['extension' => 'jpg'],
                    ],
                    [
                        'name'      => 'File\MimeType',
                        'options'   => ['mimeType' => 'image/jpeg'],
                    ],
                ],
            ],
        ];
    }
}