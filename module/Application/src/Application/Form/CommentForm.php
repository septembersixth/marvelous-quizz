<?php

namespace Application\Form;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use Zend\Form\Form;

class CommentForm extends Form implements ObjectManagerAwareInterface
{
    use ProvidesObjectManager;

    public function init($name = null)
    {
        $this->setName('commentForm');

        $this
            ->add([
                'name'  => 'id',
                'type'  => 'Hidden',
            ])

            ->add([
                'name'          => 'name',
                'type'          => 'text',
                'attributes'    =>
                [
                    'placeholder' => 'Enter your name'
                ]
            ])

            ->add([
                'name'          => 'email',
                'type'          => 'text',
                'attributes'    =>
                [
                    'placeholder' => 'Enter your email'
                ]
            ])

            ->add([
                'name'          => 'text',
                'type'          => 'textarea',
                'attributes'    =>
                [
                    'placeholder' => 'Your comment'
                ]
            ])

            ->add([
                'name'      => 'csrf',
                'type'      => 'csrf',
                'options'   =>
                [
                    'csrf_options' => ['timeout' => 1200],
                ],
            ])

            ->add([
                'name'      => 'captcha',
                'type'      => 'captcha',
                'options'   =>
                [
                    'captcha'       => ['class' => 'Figlet', 'outputWidth' => 30, 'wordLen' => 2],
                ],
                'attributes' =>
                [
                    'placeholder'   => 'Captcha',
                ],
            ])

            ->add([
                'name'          => 'submit',
                'type'          => 'submit',
                'attributes'    =>
                [
                    'value'     => 'Add a comment',
                ],
            ])
        ;
    }
} 