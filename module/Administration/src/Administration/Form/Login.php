<?php

namespace Administration\Form;

use Zend\Form\Form;

class Login extends Form
{
    public function init()
    {
        $this
            ->add([
                'name'  => 'username',
                'type'  => 'text',
            ])

            ->add([
                'name'  => 'password',
                'type'  => 'password',
            ])
        ;
    }
} 