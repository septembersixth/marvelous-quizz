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
                'type'  => 'textarea',
                'name'  => 'message',
            ])

            ->add([
                'name'      => 'captcha',
                'type'      => 'captcha',
                'options'   =>
                [
                    'captcha'       => ['class' => 'Figlet',  'wordLen' => 4],
                ],
                'attributes' =>
                [
                    'placeholder'   => 'Captcha',
                ],
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
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validators'  => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => '1',
                            'max'      => '30',
                            'message'  => 'champ obligatoire',
                            'break_chain_on_failure' => true,
                        ]
                    ],
                    [
                        'name'      => 'NotEmpty',
                        'options'   => ['message'   => 'champ obligatoire'],
                        'break_chain_on_failure' => true,
                    ],
                ],
            ],

            'email' => [
                'required'  => true,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validators'  => [
                    [
                        'name' => 'EmailAddress',
                        'options' => ['message'  => 'Votre adresse email ne semble pas valide'],
                        'break_chain_on_failure' => true,
                    ],
                    [
                        'name'      => 'NotEmpty',
                        'options'   => ['message'   => 'champ obligatoire'],
                        'break_chain_on_failure' => true,
                    ],
                ],
            ],

            'message' => [
                'required'      => true,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validators'  => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => '1',
                            'max'      => '1000',
                            'message'  => '1 à 1000 mots max',
                            'break_chain_on_failure' => true,
                        ]
                    ],
                    [
                        'name'      => 'NotEmpty',
                        'options'   => ['message'   => 'champ obligatoire'],
                        'break_chain_on_failure' => true,
                    ],
                ],
            ],
        ];
    }


} 