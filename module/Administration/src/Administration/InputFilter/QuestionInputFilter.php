<?php


namespace Administration\InputFilter;

use Zend\InputFilter\InputFilter;

class QuestionInputFilter extends InputFilter
{
    public function init()
    {
        $this

            ->add([
                'name'          => 'text',
                'required'      => true,
                'filters'       => [['name' => 'StringTrim']],
            ])
        ;

    }
} 