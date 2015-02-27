<?php

return
[
    'controllers' =>
    [
        'invokables' =>
        [
            'Administration\Controller\Posts' => 'Administration\Controller\PostsController',
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
                    'route' => '/administration'
                ],

                'child_routes' =>
                [
                    'posts' => [
                        'type'      => 'segment',
                        'options'   =>
                            [
                                'route'     => '/posts[/:action[/:id]]',
                                'defaults'  =>
                                    [
                                        'controller'    => 'Administration\Controller\Posts',
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
                                'controller'    => 'Administration\Controller\Posts',
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
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
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
            'Administration\Form\PostForm' => 'Administration\Form\PostFormFactory'
        ],

        'shared' =>
        [

        ],
    ],

    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Home',
                'route' => 'home',
            ),
            array(
                'label' => 'Post',
                'route' => 'administration/posts',
            ),
        ),
    ),

    'view_helper_config' => array(
        'flashmessenger' => array(
            'message_open_format'      => '<div%s><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul><li>',
            'message_close_string'     => '</li></ul></div>',
            'message_separator_string' => '</li><li>'
        )
    ),

];