<?php
	
	
	namespace mvc_router\mvc\controllers;
	
	
	use mvc_router\mvc\Controller;
	
	class Api extends Controller {
		
		/**
		 * @route /documentation/api
		 *
		 * @param \mvc_router\mvc\views\Api $view
		 * @return \mvc_router\mvc\views\Api
		 */
		public function index(\mvc_router\mvc\views\Api $view): \mvc_router\mvc\views\Api {
			$view->assign('current_page', 'api');
			return $view;
		}
	}