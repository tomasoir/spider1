<?php
// module/Spider/config/module.config.php:
return array(
    'controllers' => array(
		'invokables' => array(
			'Spider\Controller\Spider' => 'Spider\Controller\SpiderController',
	    ),
	),
	// The following section is new and should be added to your file
	'router' => array(
				'routes' => array(
					'spider' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/spider[/:action][/:id]',
							'constraints' => array(
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+',
							),
							'defaults' => array(
								'controller' => 'Spider\Controller\Spider',
								'action' => 'index',
							),
						),
					),
				),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'spider' => __DIR__ . '/../view',
		),
	),
);