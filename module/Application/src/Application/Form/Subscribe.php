<?php

namespace Application\Form;

use Zend\Form\Form;

class Subscribe extends Form
{
    public function init($name = 'subscribe')
    {
        $this->setName($name);

        $this
            ->add([
                'name'  => 'id',
                'type'  => 'Hidden',
            ])

            ->add([
                'name'  => 'firstname',
                'type'  => 'Text',
            ])

            ->add([
                'name'  => 'lastname',
                'type'  => 'Text',
            ])

            ->add([
                'name'  => 'email',
                'type'  => 'Email',
            ])

            ->add([
                'name'  => 'phone',
                'type'  => 'Text',
            ])

            ->add([
                'name'  => 'password',
                'type'  => 'Password',
            ])

            ->add([
                'name'  => 'submit',
                'type'  => 'Submit',
                'attributes' =>
                    [
                        'value'     => 'Submit',
                        'id'        => 'submit',
                        'class'     => 'btn btn-default',
                    ],
            ])
        ;
    }


} 