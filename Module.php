<?php 
 // module/Spider/Module.php
namespace Spider;
use Spider\Model\SpiderTable;
class Module
{
	public function getAutoloaderConfig()
	{
	  return array(
		'Zend\Loader\ClassMapAutoloader' => array(
			__DIR__ . '/autoload_classmap.php', ),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}
	
	public function getConfig(){
	  return include __DIR__ . '/config/module.config.php';
	}

	public function getServiceConfig(){
			return array(
				'factories' => array(
					'Spider\Model\SpiderTable' => function($sm) {
						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
						$table = new SpiderTable($dbAdapter);
						return $table;
					},
				),
			);
	}



}