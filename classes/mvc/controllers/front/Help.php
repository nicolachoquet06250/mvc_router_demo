<?php
	
	
	namespace mvc_router\mvc\controllers;
	
	
	use mvc_router\mvc\Controller;
	
	class Help extends Controller {
		
		/**
		 * @route /mvc-router/help
		 *
		 * @param \mvc_router\mvc\views\Help $view
		 * @return \mvc_router\mvc\views\Help
		 */
		public function index(\mvc_router\mvc\views\Help $view): \mvc_router\mvc\views\Help {
			return $view;
		}
	}