<?php
	
	
	namespace mvc_router\mvc\controllers;
	
	
	use mvc_router\mvc\Controller;
	
	class Documentation extends Controller {
		
		/**
		 * @route /documentation
		 *
		 * @param \mvc_router\mvc\views\Documentation $view
		 * @return \mvc_router\mvc\views\Documentation
		 */
		public function index(\mvc_router\mvc\views\Documentation $view): \mvc_router\mvc\views\Documentation {
			if(!$view->get('sub_page'))
				$view->assign('sub_page', 'get_started');
			$view->assign('current_page', 'documentation');
			return $view;
		}
		
		/**
		 * @route /documentation/get-started
		 *
		 * @param \mvc_router\mvc\views\Documentation $view
		 * @return \mvc_router\mvc\views\Documentation
		 */
		public function get_started(\mvc_router\mvc\views\Documentation $view): \mvc_router\mvc\views\Documentation {
			$view->assign('sub_page', 'get_started');
			return $this->index($view);
		}
		
		/**
		 * @route /documentation/services
		 *
		 * @param \mvc_router\mvc\views\Documentation $view
		 * @return \mvc_router\mvc\views\Documentation
		 */
		public function services(\mvc_router\mvc\views\Documentation $view): \mvc_router\mvc\views\Documentation {
			$view->assign('sub_page', 'services');
			return $this->index($view);
		}
		
		/**
		 * @route /documentation/controllers
		 *
		 * @param \mvc_router\mvc\views\Documentation $view
		 * @return \mvc_router\mvc\views\Documentation
		 */
		public function controllers(\mvc_router\mvc\views\Documentation $view): \mvc_router\mvc\views\Documentation {
			$view->assign('sub_page', 'controllers');
			return $this->index($view);
		}
		
		/**
		 * @route /documentation/views
		 *
		 * @param \mvc_router\mvc\views\Documentation $view
		 * @return \mvc_router\mvc\views\Documentation
		 */
		public function views(\mvc_router\mvc\views\Documentation $view): \mvc_router\mvc\views\Documentation {
			$view->assign('sub_page', 'views');
			return $this->index($view);
		}
		
		/**
		 * @route /documentation/entities
		 *
		 * @param \mvc_router\mvc\views\Documentation $view
		 * @return \mvc_router\mvc\views\Documentation
		 */
		public function entities(\mvc_router\mvc\views\Documentation $view): \mvc_router\mvc\views\Documentation {
			$view->assign('sub_page', 'entities');
			return $this->index($view);
		}
		
		/**
		 * @route /documentation/managers
		 *
		 * @param \mvc_router\mvc\views\Documentation $view
		 * @return \mvc_router\mvc\views\Documentation
		 */
		public function managers(\mvc_router\mvc\views\Documentation $view): \mvc_router\mvc\views\Documentation {
			$view->assign('sub_page', 'managers');
			return $this->index($view);
		}
		
		/**
		 * @route /documentation/commands
		 *
		 * @param \mvc_router\mvc\views\Documentation $view
		 * @return \mvc_router\mvc\views\Documentation
		 */
		public function commands(\mvc_router\mvc\views\Documentation $view): \mvc_router\mvc\views\Documentation {
			$view->assign('sub_page', 'commands');
			return $this->index($view);
		}
		
		/**
		 * @route /documentation/configurations
		 *
		 * @param \mvc_router\mvc\views\Documentation $view
		 * @return \mvc_router\mvc\views\Documentation
		 */
		public function configurations(\mvc_router\mvc\views\Documentation $view): \mvc_router\mvc\views\Documentation {
			$view->assign('sub_page', 'configurations');
			return $this->index($view);
		}
	}