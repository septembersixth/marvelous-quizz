<?php

namespace Application\InputFilter;

use DoctrineModule\Validator\NoObjectExists;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Subscribe extends InputFilter implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init()
    {
        $this
            ->add([
                'name'       => 'firstname',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validators'  => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => '3',
                            'max'      => '20',
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
            ])

            ->add([
                'name'       => 'lastname',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validators'  => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => '3',
                            'max'      => '20',
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
            ])

            ->add([
                'name'      => 'email',
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

                    [
                        'name'      => 'DoctrineModule\Validator\NoObjectExists',
                        'options'   => [
                            'object_repository' => $this->getServiceLocator()->getServiceLocator()->get('Doctrine\ORM\EntityManager')->getRepository('Application\Entity\User'),
                            'fields'            => 'login',
                            'messages'           => [NoObjectExists::ERROR_OBJECT_FOUND => 'Désolé, cet email existe dejà'],
                        ],
                    ],

                ],
            ])

            ->add([
                'name'      => 'phone',
                'required'  => false,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validators'  => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => '10',
                            'max'      => '15',
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
            ])

            ->add([
                'name'      => 'password',
                'required'  => true,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags']],
                'validators'  => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => '4',
                            'max'      => '20',
                            'message'  => 'champ obligatoire, 4 lettres minimum',
                            'break_chain_on_failure' => true,
                        ]
                    ],
                    [
                        'name'      => 'NotEmpty',
                        'options'   => ['message'   => 'champ obligatoire'],
                        'break_chain_on_failure' => true,
                    ],
                ],
            ])
        ;
    }
} 