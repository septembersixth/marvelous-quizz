<?php

namespace Administration\Form\Fieldset;

use Application\Entity\Tag;
use Application\Entity\Test;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
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
                'name'  => 'alt',
                'type'  => 'text',
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

            ->add([
                'type'      => 'MultiCheckbox',
                'name'      => 'level',
                'options'   =>
                [
                    'value_options' =>
                    [
                        Test::LEVEL_EASY            => 'facile',
                        Test::LEVEL_INTERMEDIARY    => 'intermédiaire',
                        Test::LEVEL_HARD            => 'dur',
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

                'attributes' => [
                    'class'     => 'questionFieldset',
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
                'required' => true,
            ],

            'level' => [
                'required' => true,
            ],

            'explanation' => [
                'required'      => true,
                'filters'       => [['name' => 'StringTrim']],
            ],

            'alt' => [
                'required'      => false,
                'filters'       => [['name' => 'StringTrim']],
            ],

            'image' =>
            [
                'type' => 'Zend\InputFilter\FileInput',
                'required'      => true,
                'filters'       =>
                [
                    [
                        'name' => 'File\RenameUpload',
                        'options' =>
                        [
                            'target'            => 'data/upload/test',
                            'randomize'         => true,
                            'use_upload_name'   => true,
                        ]
                    ]
                ],
                'validators'     =>
                [
                    [
                        'name'      => 'File\Size',
                        'options'   => ['max' => '1MB'],
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