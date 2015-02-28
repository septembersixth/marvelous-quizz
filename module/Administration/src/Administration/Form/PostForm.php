<?php

namespace Administration\Form;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use Zend\Form\Form;

class PostForm extends Form implements ObjectManagerAwareInterface
{
    use ProvidesObjectManager;

    public function init($name = null)
    {
        $this->setName('postForm');

        $this
            ->add([
                'name'  => 'id',
                'type'  => 'Hidden',
            ])

            ->add([
                'name'  => 'title',
                'type'  => 'text',
                'attributes' =>
                [
                    'class'         => 'form-control',
                    'placeholder'   => 'Enter title'
                ]
            ])

            ->add([
                'name'  => 'text',
                'type'  => 'textarea',
                'attributes' =>
                [
                    'class'         => 'form-control',
                    'placeholder'   => 'Enter content',
                    'rows'          => '8'
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

                    'label_attributes'  =>
                        [
                            'class' => 'checkbox-inline'
                        ]
                ],

            ])

        ;
    }
} 