<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return
[

    'service_manager' =>
    [
        'abstract_factories' =>
        [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],

        'factories' =>
        [
            'front\navigation' => 'Application\Service\Navigation\FrontNavigationFactory',
        ],

        'aliases' =>
        [
            'translator' => 'MvcTranslator',
        ],
    ],

    'form_elements' =>
    [
        'invokables' =>
        [
        ],

        'factories' =>
        [
            'Application\Form\Subscribe'  => 'Application\Form\SubscribeFactory',
        ]
    ],

    'input_filters' =>
    [
        'invokables' =>
        [
            'Application\InputFilter\Subscriber' => 'Application\InputFilter\Subscriber',
        ]
    ],

    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),

    'controllers' =>
    [
        'invokables' =>
        [
            'Application\Controller\Index'  => 'Application\Controller\IndexController',
            'Application\Controller\Json'   => 'Application\Controller\JsonController'
        ],
    ],

    'view_manager' =>
    [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' =>
        [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' =>
        [
            __DIR__ . '/../view',
        ],
    ],

    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),

    'router' =>
    [
        'routes' =>
        [
            'home' =>
            [
                'type'      => 'literal',
                'options'   =>
                [
                    'route'     => '/',
                    'defaults'   =>
                    [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ],
                ],

                'may_terminate' => true,

                'child_routes' =>
                [
                    'subscribe' =>
                    [
                        'type'      => 'segment',
                        'options'   =>
                        [
                            'route'         => 'subscribe/:correct/:wrong',
                            'constraints'   =>
                            [
                                'correct'   => '[0-9]+',
                                'wrong'     => '[0-9]+',
                            ],
                            'defaults'   =>
                            [
                                'action'        => 'subscribe',
                            ],
                        ],
                    ],

                    'result' =>
                    [
                        'type'      => 'segment',
                        'options'   =>
                        [
                            'route'         => 'result/:correct/:wrong',
                            'constraints'   =>
                            [
                                'correct'   => '[0-9]+',
                                'wrong'     => '[0-9]+',
                            ],
                            'defaults'   =>
                            [
                                'action'        => 'result',
                            ],
                        ],
                    ],
                ],
            ],

            'json' =>
            [
                'type'      => 'literal',
                'options'   =>
                [
                    'route'         => '/json',
                    'defaults'       =>
                    [
                        'controller'    => 'Application\Controller\Json',
                    ],
                ],

                'child_routes' =>
                [
                    'test'  =>
                    [
                        'type'      => 'segment',
                        'options'   =>
                        [
                            'route'     => '/tests[/:params]',
                            'defaults'   =>
                            [
                                'action' => 'tests',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'doctrine' =>
    [
        'driver' =>
        [
            'application_entities' =>
            [
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Application/Entity'],
            ],

            'orm_default' =>
            [
                'drivers' =>
                [
                    'Application\Entity' => 'application_entities',
                ],
            ],
        ],
    ],

    'view_helpers' =>
    [
        'invokables' =>
        [
        ],
    ],

];
