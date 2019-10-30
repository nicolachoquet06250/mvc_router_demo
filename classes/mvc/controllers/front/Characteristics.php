<?php
	
	
	namespace mvc_router\mvc\controllers;
	
	
	use mvc_router\mvc\Controller;
	
	class Characteristics extends Controller {
		
		/**
		 * @route /about
		 *
		 * @param \mvc_router\mvc\views\Characteristics $view
		 * @return \mvc_router\mvc\views\Characteristics
		 */
		public function about(\mvc_router\mvc\views\Characteristics $view): \mvc_router\mvc\views\Characteristics {
			$view->assign('current_page', 'about');
			return $view;
		}
		
		/**
		 * @route /partners
		 *
		 * @param \mvc_router\mvc\views\Characteristics $view
		 * @return \mvc_router\mvc\views\Characteristics
		 */
		public function partners(\mvc_router\mvc\views\Characteristics $view): \mvc_router\mvc\views\Characteristics {
			$view->assign('current_page', 'partners');
			return $view;
		}
		
		/**
		 * @route /updates
		 *
		 * @param \mvc_router\mvc\views\Characteristics $view
		 * @return \mvc_router\mvc\views\Characteristics
		 */
		public function updates(\mvc_router\mvc\views\Characteristics $view): \mvc_router\mvc\views\Characteristics {
			$view->assign('current_page', 'updates');
			return $view;
		}
	}