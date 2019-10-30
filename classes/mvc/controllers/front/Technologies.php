<?php
	
	
	namespace mvc_router\mvc\controllers;
	
	
	use mvc_router\mvc\Controller;
	
	class Technologies extends Controller {
		
		/**
		 * @route /tech/how-to-works
		 *
		 * @param \mvc_router\mvc\views\Technologies $view
		 * @return \mvc_router\mvc\views\Technologies
		 */
		public function how_to_works(\mvc_router\mvc\views\Technologies $view):\mvc_router\mvc\views\Technologies {
			$view->assign('current_page', 'how_to_works');
			return $view;
		}
		
		/**
		 * @route /tech/patterns
		 *
		 * @param \mvc_router\mvc\views\Technologies $view
		 * @return \mvc_router\mvc\views\Technologies
		 */
		public function patterns(\mvc_router\mvc\views\Technologies $view):\mvc_router\mvc\views\Technologies {
			$view->assign('current_page', 'patterns');
			return $view;
		}
		
		/**
		 * @route /tech/usage
		 *
		 * @param \mvc_router\mvc\views\Technologies $view
		 * @return \mvc_router\mvc\views\Technologies
		 */
		public function usage(\mvc_router\mvc\views\Technologies $view):\mvc_router\mvc\views\Technologies {
			$view->assign('current_page', 'usage');
			return $view;
		}
		
		/**
		 * @route /tech/products
		 *
		 * @param \mvc_router\mvc\views\Technologies $view
		 * @return \mvc_router\mvc\views\Technologies
		 */
		public function products(\mvc_router\mvc\views\Technologies $view):\mvc_router\mvc\views\Technologies {
			$view->assign('current_page', 'products');
			return $view;
		}
		
		/**
		 * @route /tech/contracts
		 *
		 * @param \mvc_router\mvc\views\Technologies $view
		 * @return \mvc_router\mvc\views\Technologies
		 */
		public function contracts(\mvc_router\mvc\views\Technologies $view):\mvc_router\mvc\views\Technologies {
			$view->assign('current_page', 'contracts');
			return $view;
		}
	}