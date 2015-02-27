<?php

return
[
    'controllers' =>
    [
        'invokables' =>
        [
            'Administration\Controller\Posts' => 'Administration\Controller\PostsController',
            'Administration\Controller\Index' => 'Administration\Controller\IndexController',
        ],
    ],

    'router' =>
    [
        'routes' =>
        [
            'administration' =>
            [
                'type'      => 'segment',
                'options'   =>
                [
                    'route'      => '/administration',
                    'defaults'   =>
                    [
                        '__NAMESPACE__' => 'Administration\Controller',
                        'controller'    => 'Index',
                    ],
                ],

                'child_routes' =>
                [
                    'login' =>
                    [
                        'type'      => 'literal',
                        'options'   =>
                        [
                            'route'     => '/login',
                            'defaults'  =>
                            [
                                'action'    => 'login'
                            ],
                        ],
                    ],

                    'logout' =>
                    [
                        'type'      => 'literal',
                        'options'   =>
                        [
                            'route'     => '/logout',
                            'defaults'   =>
                            [
                                'action'    => 'logout',
                            ],
                        ],
                    ],

                    'posts' =>
                    [
                        'type'      => 'segment',
                        'options'   =>
                            [
                                'route'     => '/posts[/:action[/:id]]',
                                'defaults'  =>
                                [
                                    'controller'    => 'Posts',
                                    'action'        => 'index',
                                ],
                            ],
                    ],

                    'pagination' =>
                    [
                        'type'      => 'segment',
                        'options'   =>
                        [
                            'route'         => '/posts/[page/:page]',
                            'defaults'      =>
                            [
                                'page'          => 1,
                                'controller'    => 'Posts',
                                'action'        => 'index',
                            ],

                        ],

                    ],


                ],
            ],
        ],
    ],

    'view_manager' =>
    [
        'template_path_stack' =>
        [
            'administration' => __DIR__ . '/../view',
        ],
    ],

    'service_manager' =>
    [
        'invokables' =>
        [

        ],

        'factories' =>
        [
            'navigation'                                    => 'Zend\Navigation\Service\DefaultNavigationFactory',
//            'Zend\Authentication\AuthenticationService'     => 'Administration\Service\Auth\AuthenticationFactory',
            'Zend\Authentication\AuthenticationService'     => function($serviceManager) {
                // If you are using DoctrineORMModule:
                return $serviceManager->get('doctrine.authenticationservice.orm_default');
            }

        ],

        'shared' =>
        [

        ],
    ],

    'input_filters' =>
    [
        'invokables' =>
        [
            'Administration\InputFilter\PostInputFilter' => 'Administration\InputFilter\PostInputFilter',
        ],

        'shared' =>
        [

        ],
    ],

    'form_elements' =>
    [
        'invokables' =>
        [

        ],

        'factories' =>
        [
            'Administration\Form\PostForm'                  => 'Administration\Form\PostFormFactory',
            'Administration\Form\Login'                     => 'Administration\Form\LoginFactory',


        ],

        'shared' =>
        [

        ],
    ],

    'navigation' =>
    [
        'default' =>
        [
            [
                'label' => 'Home',
                'route' => 'home',
            ],
            [
                'label' => 'Post',
                'route' => 'administration/posts',
            ],
        ],
    ],

    'view_helper_config' => array(
        'flashmessenger' => array(
            'message_open_format'      => '<div%s><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul><li>',
            'message_close_string'     => '</li></ul></div>',
            'message_separator_string' => '</li><li>'
        )
    ),

    'doctrine' =>
    [
        'authentication' =>
        [
            'orm_default' =>
            [
                'object_manager'      => 'Doctrine\ORM\EntityManager',
                'identity_class'      => 'Administration\Entity\User',
                'identity_property'   => 'login',
                'credential_property' => 'password',
                'credential_callable' => function(\Administration\Entity\User $user, $passwordGiven) {
                    return $user->getPassword() === md5($passwordGiven);
                },
            ],
        ],

        'driver' =>
        [
            'application_entities' =>
                [
                    'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/../src/Administration/Entity'],
                ],

            'orm_default' =>
                [
                    'drivers' =>
                        [
                            'Administration\Entity' => 'application_entities',
                        ],
                ],
        ],
    ],

];