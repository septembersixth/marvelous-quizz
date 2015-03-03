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
//                'filters'       => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validators'    => [
                    ['name'    => 'StringLength', 'options' => ['min' => '3', 'max' => '3000']]
                ],
            ])

            ->add([
                'name'          => 'text',
                'required'      => true,
//                'filters'       => [['name' => 'StringTrim'], ['name' => 'StripTags']],
//                'validators'    => [
//                    ['name'     => 'StringLength', 'options' => ['min' => '3', 'max' => '10000']]
//                ],
            ])

            ->add([
                'name'          => 'tags',
                'required'      => false,
            ])


            ->add([
                'name'          => 'image',
                'required'      => false,
                'filters'       => [[
                                    'name' => 'File\RenameUpload',
                                    'options' => [
                                                    'target'    => 'data/upload',
                                                    'randomize' => true,
                                                ]
                                    ]],
                'validators'     => [
                                        [
                                            'name'      => 'File\Size',
                                            'options'   => ['max' => '2MB'],
                                        ],
                                        [
                                            'name'      => 'File\Extension',
                                            'options'   => ['extension' => 'jpg, gif'],
                                        ],
                                        [
                                            'name'      => 'File\MimeType',
                                            'options'   => ['mimeType' => 'image/jpeg, image/gif'],
                                        ],
                                    ],
            ])

        ;

    }
} 