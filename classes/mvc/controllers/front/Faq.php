<?php
	
	
	namespace mvc_router\mvc\controllers;
	
	
	use mvc_router\http\errors\Exception404;
	use mvc_router\mvc\Controller;
	use mvc_router\services\Error;
	
	class Faq extends Controller {
		
		/**
		 * @route /faq/questions
		 *
		 * @param \mvc_router\mvc\views\Faq $view
		 * @return \mvc_router\mvc\views\Faq
		 */
		public function questions(\mvc_router\mvc\views\Faq $view):\mvc_router\mvc\views\Faq {
			$view->assign('current_page', 'questions');
			return $view;
		}
		
		/**
		 * @route /faq/answers
		 *
		 * @param \mvc_router\mvc\views\Faq $view
		 * @return \mvc_router\mvc\views\Faq
		 */
		public function answers(\mvc_router\mvc\views\Faq $view):\mvc_router\mvc\views\Faq {
			$view->assign('current_page', 'answers');
			return $view;
		}
		
		/**
		 * @route /faq/contact-us
		 *
		 * @param \mvc_router\mvc\views\Faq $view
		 * @return \mvc_router\mvc\views\Faq
		 */
		public function contact_us(\mvc_router\mvc\views\Faq $view):\mvc_router\mvc\views\Faq {
			$view->assign('current_page', 'contact_us');
			return $view;
		}
	}