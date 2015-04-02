<?php

namespace Application\InputFilter;

use Zend\InputFilter\InputFilter;

class Subscribe extends InputFilter
{
    public function init()
    {
        $this
            ->add([
                'name'       => 'firstname',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validator'  => [[
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => '3',
                        'max'      => '100',
                    ],
                ]],
            ])

            ->add([
                'name'       => 'lastname',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validator'  => [[
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => '3',
                        'max'      => '100',
                    ],
                ]],
            ])

            ->add([
                'name'      => 'email',
                'required'  => true,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validator'  => [[
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => '3',
                        'max'      => '100',
                    ],
                ]],
            ])

            ->add([
                'name'      => 'phone',
                'required'  => false,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validator'  => [[
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => '3',
                        'max'      => '20',
                    ],
                ]],
            ])

            ->add([
                'name'      => 'password',
                'required'  => true,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validator'  => [[
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => '4',
                        'max'      => '20',
                    ],
                ]],
            ])
        ;
    }
} 