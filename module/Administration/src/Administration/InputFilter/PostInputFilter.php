<?php


namespace Administration\InputFilter;

use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;

class PostInputFilter extends InputFilter
{
    public function init()
    {
        $this
            ->add([
                'name'          => 'title',
                'required'      => true,
                'filters'       => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validators'    => [
                    ['name'    => 'StringLength', 'options' => ['min' => '3', 'max' => '64']]
                ],
            ])

            ->add([
                'name'          => 'text',
                'required'      => true,
                'filters'       => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validators'    => [
                    ['name'     => 'StringLength', 'options' => ['min' => '3', 'max' => '64']]
                ],
            ])

            ->add([
                'name'          => 'tags',
                'required'      => false,
            ])


            ->add([
                'name'          => 'image',
                'required'      => false,
                'filters'       => [['name' => 'FileRenameUpload',
                                    'options' => [
                                                    'target'    => './data/upload/',
                                                    'randomize' => true,
                                                ]
                                    ]],
                'validator'     => [['name' => 'UploadFile']],
            ])



        ;

    }
} 