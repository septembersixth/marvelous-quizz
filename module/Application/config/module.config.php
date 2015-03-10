<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => [
        'routes' => [

            'home' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ],

            'post' =>
            [
                'type'      => 'segment',
                'options'   =>
                [
                    'route'         => '/post/:url',
                    'constraint'    =>
                    [
                        'url'       => '[a-zA-Z0-9_-]+',
                    ],
                    'defaults'      =>
                    [
                        'controller'    => 'Application\Controller\Index',
                        'action'        => 'post',
                    ],
                ],
            ],

            'comment' =>
            [
                'type'      => 'segment',
                'options'   =>
                [
                    'route'         => '/comment/post/:postId',
                    'constraint'    =>
                    [
                        'postId'    => '[0-9]+',
                    ],
                    'defaults'      =>
                    [
                        'controller'    => 'Application\Controller\Index',
                        'action'        => 'comment',
                    ]
                ],
            ],

            'tag' =>
            [
                'type'      => 'segment',
                'options'   =>
                [
                    'route'         => '/tag/:tagName',
                    'constraint'    =>
                    [
                        'tagName'       => '[a-zA-Z0-9_-]+',
                    ],
                    'defaults'      =>
                    [
                        'controller'    => 'Application\Controller\Index',
                        'action'        => 'tag',
                    ],
                ],
            ],
        ],
    ],

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
            'Application\Form\CommentForm'  => 'Application\Form\CommentFormFactory',
        ]
    ],

    'input_filters' =>
    [
        'invokables' =>
        [
            'Application\InputFilter\CommentFilter' => 'Application\InputFilter\CommentFilter',
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
            'Application\Controller\Index' => 'Application\Controller\IndexController'
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

    'navigation' =>
    [
        'front' =>
        [
            [
                'label' => 'Home',
                'route' => 'home',
            ],
            [
                'label' => 'Humeur',
                'route' => 'tag',
                'params' =>
                [
                    'tagName' => 'humeur',
                ],
            ],
            [
                'label' => 'Famille',
                'route' => 'tag',
                'params' =>
                [
                    'tagName' => 'famille',
                ],
            ],
            [
                'label' => 'Miam Miam',
                'route' => 'tag',
                'params' =>
                [
                    'tagName' => 'miam_miam',
                ],
            ],
        ],
    ],
);
