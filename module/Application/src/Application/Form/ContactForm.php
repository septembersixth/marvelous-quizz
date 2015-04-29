<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\ModuleManager\Feature\InputFilterProviderInterface;

class ContactForm extends Form implements InputFilterProviderInterface
{
    public function init($name = null)
    {
        $this
            ->add([
                'type'  => 'text',
                'name'  => 'name',
            ])

            ->add([
                'type'  => 'text',
                'name'  => 'email',
            ])

            ->add([
                'type'  => 'text',
                'name'  => 'message',
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

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getInputFilterConfig()
    {
        return [

            'name' => [
                'required'      => true,
                'filters'       => [['name' => 'StringTrim']],
            ],

            'email' => [
                'required'      => true,
                'filters'       => [['name' => 'StringTrim']],
            ],

            'message' => [
                'required'      => true,
                'filters'       => [['name' => 'StringTrim']],
            ],
        ];
    }


} 