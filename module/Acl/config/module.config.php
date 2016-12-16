<?php

namespace Acl;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Acl\Controller;

return [
    'router' => [
        'routes' => [
            'acl' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/acl'
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'post' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '[/:controller[/:action[/:id]]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\RoleController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                ]
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'acl' => __DIR__ . "/../view"
        ]
    ],
    'doctrine' => [
        'driver' => [
            'Acl_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    'Acl\Entity' => 'Acl_driver'
                ]
            ]
        ],
        'fixtures' => [
            'AclFixture' => __DIR__ . '/../src/Entity/Fixture'
        ]
    ]
];