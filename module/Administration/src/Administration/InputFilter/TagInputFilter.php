<?php


namespace Administration\InputFilter;

use Zend\InputFilter\InputFilter;

class TagInputFilter extends InputFilter
{
    public function init()
    {
        $this
            ->add([
                'name'          => 'name',
                'required'      => true,
                'filters'       => [['name' => 'StringTrim']],
            ])

        ;

    }
} 