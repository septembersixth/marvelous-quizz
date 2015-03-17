<?php

namespace Administration\Form;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use Zend\Form\Form;

class QuestionForm extends Form
{

    public function init($name = null)
    {
        $this->setName('questionForm');

        $this
            ->add([
                'name'  => 'id',
                'type'  => 'Hidden',
            ])

            ->add([
                'name'  => 'text',
                'type'  => 'text',
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