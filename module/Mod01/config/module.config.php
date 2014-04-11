<?php

namespace Mod01;

return array(
    'errors' => array(
        'post_processor' => 'json-pp',
        'show_exceptions' => array(
            'message' => true,
            'trace'   => false
        )
    ),
    'di' => array(
        'instance' => array(
            'alias' => array(
                'json-pp'  => 'Mod01\PostProcessor\Json',
                'xml-pp'   => 'Mod01\PostProcessor\Xml',
                'image-pp' => 'Mod1\PostProcessor\Image',
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'categoria'   => 'Mod01\Controller\CategoriaController',
            'musico'      => 'Mod01\Controller\MusicoController',
            'usuario'     => 'Mod01\Controller\UsuarioController',
            'Instrumento' => 'Mod01\Controller\InstrumentoController',
        )
    ),
    'router' => array(
        'routes' => array(
            'restful' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'       => '/api/:controller[/:formatter][/:id[/]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'formatter'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'         => '[a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array (
                        'formatter' => 'json'
                    )
                ),
            ),
        ),
    ),
);
