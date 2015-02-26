<?php

namespace Administration\Form;

use Zend\Form\Form;

class PostForm extends Form
{
    public function init($name = null)
    {
        $this->setName('postForm');

        $this
            ->add([
                'name'  => 'id',
                'type'  => 'Hidden',
            ])

            ->add([
                'name'  => 'title',
                'type'  => 'text',
                'attributes' =>
                [
                    'class'         => 'form-control',
                    'placeholder'   => 'Enter title'
                ]
            ])

            ->add([
                'name'  => 'text',
                'type'  => 'textarea',
                'attributes' =>
                [
                    'class'         => 'form-control',
                    'placeholder'   => 'Enter content',
                    'rows'          => '8'
                ],
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