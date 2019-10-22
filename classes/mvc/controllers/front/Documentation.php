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
			return $this->index($view);
		}
	}