<?php

namespace Administration\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class CreateTestForm extends Form implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init()
    {
        $this
            ->setAttribute('method', 'post')
        ;

        $this
            ->add([
                'type'       => 'Administration\Form\Fieldset\TestFieldset',
                'options'    => ['use_as_base_fieldset' => true],
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