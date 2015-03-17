<?php

namespace Administration\Form\Fieldset;

use Application\Entity\Test;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use DoctrineModuleTest\Stdlib\Hydrator\DoctrineObjectTest;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class TestFieldset extends Fieldset implements InputFilterProviderInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init()
    {
        $em = $this->getServiceLocator()->getServiceLocator()->get('doctrine\ORM\EntityManager');

        $this->setName('test');

        $this
            ->setHydrator(new DoctrineObject($em))
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


//            $questionFieldset = new QuestionFieldset($this->getObjectManager());
//            $questionFieldset = new QuestionFieldset;
            $this->add([
                'type'    => 'Zend\Form\Element\Collection',
                'name'    => 'questions',
                'options' => [
                    'label' => 'Please choose categories for this product',
                    'should_create_template' => true,
                    'count'           => 2,
//                    'allow_add' => true,
                    'target_element' => ['type' => 'Administration\Form\Fieldset\QuestionFieldset' ],
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