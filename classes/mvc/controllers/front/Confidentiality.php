<?php
	
	
	namespace mvc_router\mvc\controllers;
	
	
	use mvc_router\mvc\Controller;
	
	class Confidentiality extends Controller {
		
		/**
		 * @route /mvc-router/confidentiality
		 *
		 * @param \mvc_router\mvc\views\Confidentiality $view
		 * @return \mvc_router\mvc\views\Confidentiality
		 */
		public function index(\mvc_router\mvc\views\Confidentiality $view): \mvc_router\mvc\views\Confidentiality {
			return $view;
		}
	}