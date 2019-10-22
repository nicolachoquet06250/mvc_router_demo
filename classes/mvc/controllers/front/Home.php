<?php
	
	
	namespace mvc_router\mvc\controllers;
	
	
	use mvc_router\mvc\Controller;
	
	class Home extends Controller {
		
		/**
		 * @route /home
		 *
		 * @param \mvc_router\mvc\views\Home $view
		 * @return \mvc_router\mvc\views\Home
		 */
		public function index(\mvc_router\mvc\views\Home $view): \mvc_router\mvc\views\Home {
			$view->assign('current_page', 'home');
			return $view;
		}
	}