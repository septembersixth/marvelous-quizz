<?php


namespace Administration\InputFilter;

use Zend\InputFilter\InputFilter;

class PostInputFilter extends InputFilter
{
    public function init()
    {
        $this
            ->add([
                'name'          => 'title',
                'required'      => true,
                'filter'        => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validators'    => [
                    ['name'    => 'StringLength', 'options' => ['min' => '3', 'max' => '64']]
                ],
            ])

            ->add([
                'name'          => 'text',
                'required'      => true,
                'filter'        => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validators'    => [
                    ['name'    => 'StringLength', 'options' => ['min' => '3', 'max' => '64']]
                ],
            ])
        ;
    }
} 