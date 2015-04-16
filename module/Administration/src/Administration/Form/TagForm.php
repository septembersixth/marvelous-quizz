<?php

namespace Administration\Form;

use Application\Entity\Tag;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use Zend\Form\Form;

class TagForm extends Form implements ObjectManagerAwareInterface
{
    use ProvidesObjectManager;

    public function init($name = null)
    {
        $this->setName('tagForm');

        $this
            ->add([
                'name'  => 'id',
                'type'  => 'Hidden',
            ])

            ->add([
                'name'  => 'name',
                'type'  => 'text',
                'attributes' =>
                [
                    'class'         => 'form-control',
                    'placeholder'   => 'Enter tag name'
                ]
            ])

            ->add([
                'name'      => 'type',
                'type'      => 'select',
                'options'   =>
                [
                    'value_options' => [Tag::TYPE_ONE => 'difficulté', Tag::TYPE_TWO => 'type'],
                    'empty_option'  => 'Please choose the type',
                ],
                'attributes' =>
                [
                    'class'         => 'form-control',
                ]
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
        ;
    }
} 