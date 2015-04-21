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