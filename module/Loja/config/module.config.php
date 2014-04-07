<?php

namespace Loja;

return array(
    'router' => array(
        'routes' => array(
            'loja-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/loja',
                    'defaults' => array(
                        'controller' => 'Loja\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'loja-admin-interna' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/[:controller[/:action]][/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+'
                    )
                ),
            ),
            'loja-admin' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/[:controller[/:action][/page/:page]]',
                    'defaults' => array(
                        'action' => 'index',
                        'page' => 1
                    ),
                ),
            ),
            'loja-admin-auth' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/auth',
                    'defaults' => array(
                        'action' => 'index',
                        'controller' => 'loja-admin/auth'
                    ),
                ),
            ),
            'loja-admin-logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/auth/logout',
                    'defaults' => array(
                        'action' => 'logout',
                        'controller' => 'loja-admin/auth'
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Loja\Controller\Index' => 'Loja\Controller\IndexController',
            'categorias' => 'LojaAdmin\Controller\CategoriasController',
            'instrumentos' => 'LojaAdmin\Controller\InstrumentosController',
            'musicos' => 'LojaAdmin\Controller\MusicosController',
            'users' => 'LojaAdmin\Controller\UsersController',
            'loja-admin/auth' => 'LojaAdmin\Controller\AuthController',
        ),
    ),
    'module_layouts' => Array(
        'Loja' => 'layout/layout',
        'LojaAdmin' => 'layout/layout-admin'
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'loja/index/index' => __DIR__ . '/../view/loja/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
    ),
);
