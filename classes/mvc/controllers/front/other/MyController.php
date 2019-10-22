<?php

namespace mvc_router\mvc\controllers;

use Exception;
use mvc_router\data\gesture\custom\managers\User;
use mvc_router\mvc\Controller;
use mvc_router\router\Router;
use mvc_router\services\Service;

class MyController extends Controller {
	/** @var \mvc_router\services\Translate $service_translation */
	public $service_translation;

	/**
	 * @route /mon/example/
	 * @return string
	 */
	public function index(): string {
		return 'index';
	}

	/**
	 * @route /mon/example/2
	 * @param Service $my_service
	 */
	public function test(Service $my_service) {
		$my_service->hello();
	}

	/**
	 * @route \/([a-zA-Z]+)\/([0-9]+)
	 * @param Router $router
	 * @param        $param1
	 * @param        $param2
	 */
	public function test2(Router $router, $param1, $param2) {
		echo '<pre>';
		var_dump($router->get_current_route());
		var_dump($param1, $param2);
		echo '</pre>';
	}

	/**
	 * @route /test/lol/var
	 * @return string
	 */
	public function toto(): string {
		return 'hello 1';
	}

	/**
	 * @route \/(?<param1>[a-zA-Z0-9]+)\/hello-toi
	 * @param Service $service
	 */
	public function hello_toi(Service $service) {
		echo '<pre>';
		$service->hello();
		var_dump($this->param('param1'));
		echo '</pre>';
	}

	/**
	 * @route /conf
	 */
	public function test_confs(): string {
		return $this->html($this->service_translation->get_default_language());
	}
	
	/**
	 * @route /test/managers
	 * @param User $manager
	 * @return string
	 * @throws Exception
	 */
	public function test_manager( User $manager): string {
		return '<pre>'.$this->var_dump($manager->get_entity());
	}
}