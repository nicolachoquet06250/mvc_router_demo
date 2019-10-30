<?php
	
	
	namespace mvc_router\mvc\controllers;
	
	
	use mvc_router\mvc\Controller;
	
	class Details extends Controller {
		
		/**
		 * @route /details/specs
		 *
		 * @param \mvc_router\mvc\views\Details $view
		 * @return \mvc_router\mvc\views\Details
		 */
		public function specs(\mvc_router\mvc\views\Details $view):\mvc_router\mvc\views\Details {
			$view->assign('current_page', 'specs');
			return $view;
		}
		
		/**
		 *
		 * @route /details/tools
		 *
		 * @param \mvc_router\mvc\views\Details $view
		 * @return \mvc_router\mvc\views\Details
		 */
		public function tools(\mvc_router\mvc\views\Details $view):\mvc_router\mvc\views\Details {
			$view->assign('current_page', 'tools');
			return $view;
		}
		
		/**
		 * @route /details/resources
		 *
		 * @param \mvc_router\mvc\views\Details $view
		 * @return \mvc_router\mvc\views\Details
		 */
		public function resources(\mvc_router\mvc\views\Details $view):\mvc_router\mvc\views\Details {
			$view->assign('current_page', 'resources');
			return $view;
		}
	}