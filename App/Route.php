<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'IndexController',
			'action' => 'index'
		);
		$routes['register_employee'] = array(
			'route' => '/register_employee',
			'controller' => 'IndexController',
			'action' => 'registerEmployee'
		);
		$routes['edit_employee'] = array(
			'route' => '/edit_employee',
			'controller' => 'IndexController',
			'action' => 'editEmployee'
		);
		$routes['update_employee'] = array(
			'route' => '/update_employee',
			'controller' => 'IndexController',
			'action' => 'updateEmployee'
		);
		$routes['remove_employee'] = array(
			'route' => '/remove_employee',
			'controller' => 'IndexController',
			'action' => 'removeEmployee'
		);
		$routes['delete_employee'] = array(
			'route' => '/delete_employee',
			'controller' => 'IndexController',
			'action' => 'deleteEmployee'
		);
		$routes['export_employee'] = array(
			'route' => '/export_employee',
			'controller' => 'IndexController',
			'action' => 'exportEmployee'
		);
		
		$this->setRoutes($routes);
	}

}

?>