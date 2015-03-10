<?php

namespace Application\InputFilter;

use Zend\InputFilter\InputFilter;

class CommentFilter extends InputFilter
{
    public function init()
    {
        $this
            ->add([
                'name'       => 'name',
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
                'name'      => 'text',
                'required'  => true,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validator'  => [[
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => '3',
                        'max'      => '500',
                    ],
                ]],
            ])
        ;
    }
} 