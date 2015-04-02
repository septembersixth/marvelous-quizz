<?php

return
[
    'controllers' =>
    [
        'invokables' =>
        [
            'Administration\Controller\Index'       => 'Administration\Controller\IndexController',
            'Administration\Controller\Tests'       => 'Administration\Controller\TestsController',
            'Administration\Controller\Questions'   => 'Administration\Controller\QuestionsController',
            'Administration\Controller\Tags'        => 'Administration\Controller\TagsController',

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

                    'tests' =>
                    [
                        'type'      => 'segment',
                        'options'   =>
                        [
                            'route'         => '/tests[/:action[/:id]]',
                            'constraints'   => ['id' => '[0-9]+'],
                            'defaults'      =>
                            [
                                'controller'    => 'Tests',
                                'action'        => 'index',
                            ],
                        ],
                    ],

                    'tags' =>
                    [
                        'type'      => 'segment',
                        'options'   =>
                        [
                            'route'     => '/tags[/:action[/:id]]',
                            'defaults'  =>
                            [
                                'controller'    => 'Tags',
                                'action'        => 'index',
                            ],
                        ],
                    ],

                    'pagination' =>
                    [
                        'type'      => 'segment',
                        'options'   =>
                        [
                            'route'         => '/tests[/page/:page]',
                            'defaults'      =>
                            [
                                'page'          => 1,
                                'controller'    => 'Tests',
                                'action'        => 'index',
                            ],

                        ],
                    ],

                    'tagsPagination' =>
                    [
                        'type'      => 'segment',
                        'options'   =>
                        [
                            'route'         => '/tags[/page/:page]',
                            'defaults'      =>
                            [
                                'page'          => 1,
                                'controller'    => 'Tags',
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
            'Zend\Authentication\AuthenticationService'     => function($serviceManager) {
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
            'Administration\InputFilter\TestInputFilter'            => 'Administration\InputFilter\TestInputFilter',
            'Administration\InputFilter\QuestionInputFilter'        => 'Administration\InputFilter\QuestionInputFilter',
            'Administration\InputFilter\TagInputFilter'             => 'Administration\InputFilter\TagInputFilter',
        ],

        'shared' =>
        [

        ],
    ],

    'form_elements' =>
    [
        'invokables' =>
        [
            'Administration\Form\CreateTestForm'            => 'Administration\Form\CreateTestForm',
        ],

        'factories' =>
        [
            'Administration\Form\Login'                     => 'Administration\Form\LoginFactory',
            'Administration\Form\TestForm'                  => 'Administration\Form\TestFormFactory',
            'Administration\Form\QuestionForm'              => 'Administration\Form\QuestionFormFactory',
            'Administration\Form\TagForm'                   => 'Administration\Form\TagFormFactory',
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
                'label'     => 'Home',
                'route'     => 'home',
            ],
            [
                'label'     => 'Tests',
                'route'     => 'administration/tests',
            ],
            [
                'label'     => 'Tags',
                'route'     => 'administration/tags',
            ],
        ],
    ],

    'view_helper_config' => [
        'flashmessenger' => [
            'message_open_format'      => '<div%s><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul><li>',
            'message_close_string'     => '</li></ul></div>',
            'message_separator_string' => '</li><li>'
        ],
    ],

    'view_helpers' =>
    [
        'invokables' => [
            'questionCollection'    => 'Administration\View\Helper\QuestionCollection',
            'questionRow'           => 'Administration\View\Helper\QuestionRow',
        ],
    ],

    'doctrine' =>
    [
        'authentication' =>
        [
            'orm_default' =>
            [
                'object_manager'      => 'Doctrine\ORM\EntityManager',
                'identity_class'      => 'Application\Entity\User',
                'identity_property'   => 'login',
                'credential_property' => 'password',
                'credential_callable' => function(\Application\Entity\User $user, $passwordGiven) {
                    return $user->getPassword() === md5($passwordGiven);
                },
            ],
        ],

        'driver' =>
        [
            'administration_entities' =>
                [
                    'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/../src/Administration/Entity'],
                ],

            'orm_default' =>
                [
                    'drivers' =>
                        [
                            'Administration\Entity' => 'administration_entities',
                        ],
                ],
        ],
    ],

];