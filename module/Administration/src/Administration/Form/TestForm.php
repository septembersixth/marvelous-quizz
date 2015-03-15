<?php

namespace Administration\Form;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use Zend\Form\Form;

class TestForm extends Form implements ObjectManagerAwareInterface
{
    use ProvidesObjectManager;

    public function init($name = null)
    {
        $this->setName('testForm');
        $this->setAttribute('enctype', 'multipart/form-data');

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
                'name'  => 'submit',
                'type'  => 'Submit',
                'attributes' =>
                [
                    'value'     => 'Submit',
                    'id'        => 'submitbutton',
                    'class'     => 'btn btn-default',
                ],
            ])

            ->add([
                'type'      => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
                'name'      => 'tags',
                'options'   =>
                [
                    'object_manager'    => $this->getObjectManager(),
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
    }
} 