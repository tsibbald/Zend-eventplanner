<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Calender\Controller\Calender' => 'Calender\Controller\CalenderController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'calender' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/calender[/][:action][/:id][/:eventid]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Calender\Controller',
                        'controller'    => 'Calender',
                        'action'        => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'calender' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);